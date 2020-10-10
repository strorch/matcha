<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

return static function (): ContainerInterface {
    Dotenv::create(__DIR__ . '/../')->load();

    $containerBuilder = new ContainerBuilder();

    if (getenv('ENV') === 'prod') {
        $containerBuilder->enableCompilation(__DIR__ . '/../runtime/cache');
    }

    $settings = require __DIR__ . '/settings.php';
    $settings($containerBuilder);

    $dependencies = require __DIR__ . '/dependencies.php';
    $dependencies($containerBuilder);

    return $containerBuilder->build();
};
