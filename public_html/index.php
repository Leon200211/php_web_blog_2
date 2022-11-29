<?php

use Slim\Factory\AppFactory;

use DevCoder\DotEnv;
use Blog\Route\HomePage;
use Blog\Route\AboutPage;
use Blog\Route\BlogPage;
use Blog\Route\PostPage;


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


// домашняя страница
$app->get('/', HomePage::class . ':execute');

// страница "О нас"
$app->get('/about', AboutPage::class);

// Пагинация по блогу
$app->get('/blog[/{page}]', BlogPage::class);

// создание маршрутизации для постов
$app->get('/{url_key}', PostPage::class);




$app->run();