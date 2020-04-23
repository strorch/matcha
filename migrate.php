#!/usr/local/bin/php
<?php
declare(strict_types=1);

use App\Application\Migration\MigrationInterface;

require __DIR__ . '/vendor/autoload.php';

(static function (): void {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/config/bootstrap.php')();

    $container->get(MigrationInterface::class)->up();
})();
