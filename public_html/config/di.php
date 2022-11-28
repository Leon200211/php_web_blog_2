<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use function DI\autowire;
use function DI\get;


return [
  FilesystemLoader::class => \DI\autowire()
      ->constructorParameter('paths', 'templates'),

  Environment::class => \DI\autowire()
      ->constructorParameter('loader', \DI\get(FilesystemLoader::class))
];
