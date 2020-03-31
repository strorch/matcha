<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

//use Ratchet\Server\IoServer;
//
//(static function (): void {
//    /** @var \Psr\Container\ContainerInterface $container */
//    $container = (require __DIR__ . '/../config/bootstrap.php')();
//
//    $server = $container->get(IoServer::class);
//    $server->run();
//})();


/** @var \Psr\Container\ContainerInterface $container */
$container = (require __DIR__ . '/../config/bootstrap.php')();
$settingsProvider = $container->get(\App\Infrastructure\Provider\SettingsProviderInterface::class);
$baseSocketManager = $container->get(\App\Socket\BaseSocketManager::class);
$memcached = $container->get(\Memcached::class);
$socketParams = $settingsProvider->getSettingByName('socket');

$loop   = \React\EventLoop\Factory::create();
$webSock = new \React\Socket\Server('tcp://0.0.0.0:8000', $loop);

$webServer = new \Ratchet\Server\IoServer(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\Session\SessionProvider(
            new \Ratchet\WebSocket\WsServer($baseSocketManager),
            new \Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler($memcached)
        )
    ),
    $webSock,
    $loop
);

$webServer->run();
