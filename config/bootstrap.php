<?php

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (): ContainerInterface {

    Dotenv\Dotenv::create(__DIR__ . '/../')->load();

    $containerBuilder = new ContainerBuilder();

    if (getenv('ENV') === 'prod') { // Should be set to true in production
        $containerBuilder->enableCompilation(__DIR__ . '/../runtime/cache');
    }

    // Set up settings
    $settings = require __DIR__ . '/settings.php';
    $settings($containerBuilder);

    // Set up dependencies
    $dependencies = require __DIR__ . '/dependencies.php';
    $dependencies($containerBuilder);

    // Build PHP-DI Container instance
    return $containerBuilder->build();
};
