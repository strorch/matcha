<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return static function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        'settings' => [
            'projectDir' => __DIR__ . '/../',
            'env' => getenv('ENV'),
            'displayErrorDetails' => getenv('ENV') === 'dev',
            'logger' => [
                'name' => 'matcha',
                'path' => !empty(getenv('DOCKER')) ? 'php://stdout' : __DIR__ . '/../runtime/app.log',
                'level' => Logger::DEBUG,
            ],
            'dbParams' => [
                'type' => getenv('DB_TYPE'),
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT'),
                'dbName' => getenv('DB_NAME'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
            ],
            'socket' => [
                'host' => getenv('SOCKET_HOST'),
                'port' => getenv('SOCKET_PORT'),
            ],
        ],
    ]);
};
