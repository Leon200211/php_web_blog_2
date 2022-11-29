<?php

use Twig\Environment;
use Blog\Database;
use Twig\Loader\FilesystemLoader;

use function DI\autowire;
use function DI\get;


return [
    FilesystemLoader::class => \DI\autowire()
      ->constructorParameter('paths', 'templates'),

    Environment::class => \DI\autowire()
      ->constructorParameter('loader', \DI\get(FilesystemLoader::class)),

    Database::class => autowire()
        ->constructorParameter('dsn', getenv('DATABASE_DSN'))
        ->constructorParameter('username', getenv('DATABASE_USERNAME'))
        ->constructorParameter('password', getenv('DATABASE_PASSWORD'))

];
