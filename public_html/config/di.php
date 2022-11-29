<?php

use Twig\Environment;
use Blog\Database;
use Twig\Loader\FilesystemLoader;
use Blog\Twig\AssetExtentsion;

use function DI\autowire;
use function DI\get;


return [

    'server.params' => $_SERVER,

    FilesystemLoader::class => autowire()
      ->constructorParameter('paths', 'templates'),
    Environment::class => autowire()
      ->constructorParameter('loader', get(FilesystemLoader::class))
      ->method('addExtension', get(AssetExtentsion::class)),

    PDO::class => autowire()
        ->constructorParameter('dsn', getenv('DATABASE_DSN'))
        ->constructorParameter('username', getenv('DATABASE_USERNAME'))
        ->constructorParameter('password', getenv('DATABASE_PASSWORD'))
        ->constructorParameter('options', [])
        ->method('setAttribute', PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
        ->method('setAttribute', PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC),
    Database::class => autowire()
        ->constructorParameter('connection', get(PDO::class)),

    AssetExtentsion::class => autowire()
        ->constructorParameter('serverParams', get('server.params'))

];
