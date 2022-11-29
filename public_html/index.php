<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Blog\PostMapper;
use Blog\LatestPosts;
use Blog\Twig\AssetExtentsion;
use Blog\Slim\TwigMiddleware;
use Twig\Environment;
use DevCoder\DotEnv;
use Blog\Database;

require __DIR__ . '/vendor/autoload.php';


// переехало в config/di.php
// подключаем Twig
//$loader = new \Twig\Loader\FilesystemLoader('templates');
//$view = new \Twig\Environment($loader);


// контейнер билдер
$builder = new \DI\ContainerBuilder();
$builder->addDefinitions('config/di.php');
(new DotEnv(__DIR__ . '/.env'))->load();




$container = $builder->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

$view = $container->get(Environment::class);
$app->add(new TwigMiddleware($view));


// для подключения к БД
$connection = $container->get(Database::class)->getConnection();



$app->addErrorMiddleware(true, true, true);

// домашняя страница
$app->get('/', function (Request $request, Response $response) use ($view, $connection) {
    // Работа с БД
    $latestPosts = new LatestPosts($connection);
    $posts = $latestPosts->getLastPosts(3);
    $body = $view->render('index.twig', [
        'posts' => $posts
    ]);
    $response->getBody()->write($body);
    return $response;
});


// страница "О нас"
$app->get('/about', function (Request $request, Response $response) use ($view) {
    $body = $view->render('about.twig', [
        'name' => 'leon'
    ]);
    $response->getBody()->write($body);
    return $response;
});


// Пагинация по блогу
$app->get('/blog[/{page}]', function (Request $request, Response $response, array $args) use ($view, $connection) {
    // Работа с БД
    $postMapper = new PostMapper($connection);

    // проверяем на какой страницы находится пагинация
    $page = isset($args['page']) ? (int) $args['page'] : 1;
    // количество постов на странице
    $limit = 2;

    $posts = $postMapper->getList($page, $limit, "DESC");

    $totalCount = $postMapper->getTotalCount();

    $body = $view->render('blog.twig', [
        'posts' => $posts,
        'pagination' => [
            'current' => $page,
            'paging' => ceil($totalCount / $limit)
        ]
    ]);
    $response->getBody()->write($body);
    return $response;
});


// создание маршрутизации для постов
$app->get('/{url_key}', function (Request $request, Response $response, array $args) use ($view, $connection) {
    // Работа с БД
    $postMapper = new PostMapper($connection);
    $post = $postMapper->getByUrlKey($args['url_key']);

    if(empty($post)){
        $body = $view->render('not-found.twig', [
            'post' => $args['url_key']
        ]);
    }else{
        $body = $view->render('post.twig', [
            'post' => $post
        ]);
    }

    $response->getBody()->write($body);
    return $response;
});




$app->run();