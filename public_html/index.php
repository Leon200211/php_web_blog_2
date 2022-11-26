<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Blog\PostMapper;

require __DIR__ . '/vendor/autoload.php';

// подключаем Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$view = new \Twig\Environment($loader);


// подключение к бд
$config = include 'config/database.php';
$dsn = $config['dsn'];
$username = $config['username'];
$password = $config['password'];



// создаем подключение к БД
try{
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch (PDOException $exception){
    echo 'Database error: ' . $exception->getMessage();
    exit;
}

// Работа с БД
$postMapper = new PostMapper($connection);




$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, array $args) use ($view) {
    $body = $view->render('index.twig');
    $response->getBody()->write($body);
    return $response;
});



$app->get('/about', function (Request $request, Response $response, array $args) use ($view) {
    $body = $view->render('about.twig', [
        'name' => 'leon'
    ]);
    $response->getBody()->write($body);
    return $response;
});


// создание маршрутизации для постов
$app->get('/{url_key}', function (Request $request, Response $response, array $args) use ($view, $postMapper) {
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