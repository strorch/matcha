<?php
declare(strict_types=1);

use Ratchet\Server\IoServer;

require __DIR__ . '/../vendor/autoload.php';

(static function (): void {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/../config/bootstrap.php')();

    $container->get(IoServer::class)->run();
})();
