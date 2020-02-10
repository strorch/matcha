<?php
declare(strict_types=1);

use App\Application\Migration\MigrationInterface;

require __DIR__ . '/vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = (require __DIR__ . '/config/bootstrap.php')();

/** @var MigrationInterface $migration */
$migration = $container->get(MigrationInterface::class);
$migration->up();
