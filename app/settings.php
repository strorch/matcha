<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => [
            'domainInfoDir' =>  __DIR__ . '/../../info/',
            'displayErrorDetails' => getenv('ENV') === 'dev',
            'logger' => [
                'name' => 'rdap-server',
                'path' => !empty(getenv('DOCKER')) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'countDomains' => 15,
            'dbParams' => [
                'type' => getenv('DB_TYPE'),
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT'),
                'dbName' => getenv('DB_NAME'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
            ],
        ],
    ]);
};
