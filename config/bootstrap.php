<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

return static function (): ContainerInterface {
    error_reporting(E_ALL & ~E_NOTICE);

    \Dotenv\Dotenv::create(__DIR__ . '/../')->load();

    $containerBuilder = new ContainerBuilder();

    if (getenv('ENV') === 'prod') {
        $containerBuilder->enableCompilation(__DIR__ . '/../runtime/cache');
    }

    $settings = require __DIR__ . '/settings.php';
    $dependencies = require __DIR__ . '/dependencies.php';

    $containerBuilder->addDefinitions(['settings' => $settings]);
    $containerBuilder->addDefinitions($dependencies);

    return $containerBuilder->build();
};
