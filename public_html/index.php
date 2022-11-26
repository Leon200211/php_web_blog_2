<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;




require __DIR__ . '/vendor/autoload.php';

// подключаем Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$view = new \Twig\Environment($loader);




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
$app->get('/{url_key}', function (Request $request, Response $response, array $args) use ($view) {
    $body = $view->render('post.twig', [
        'url_key' => $args['url_key']
    ]);
    $response->getBody()->write($body);
    return $response;
});




$app->run();