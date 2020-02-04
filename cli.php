<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = (require __DIR__ . '/config/bootstrap.php')();

AppFactory::setContainer($container);
$app = AppFactory::create();
$container = $app->getContainer();

