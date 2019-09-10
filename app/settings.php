<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => [
            'domainInfoDir' =>  __DIR__ . '/../../info/',
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'rdap-server',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'countDomains' => 15,
            'dbParams' => [ // Should be set in production
                'type' => 'pgsql',
                'host' => '172.21.0.2',
                'port' => '5432',
                'dbName' => 'mrdp',
                'user' => 'sol',
                'password' => 'cnhju45l',
            ],
        ],
    ]);
};
