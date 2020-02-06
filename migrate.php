<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = (require __DIR__ . '/config/bootstrap.php')();

AppFactory::setContainer($container);
$app = AppFactory::create();
$container = $app->getContainer();

//TODO move to container
$directory = new \DirectoryIterator('migrations');
$regex = new \RegexIterator($directory, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $item) {
    $className = "\\App\\migrations\\" . reset($item);
    $className = basename($className, '.php');
    if (!class_exists($className, true)) {
        throw new \Dotenv\Exception\InvalidFileException("File {$className} does not exists");
    }

}
