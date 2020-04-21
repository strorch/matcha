<?php
declare(strict_types=1);

use App\Application\Application;

require __DIR__ . '/../vendor/autoload.php';

(static function (): void {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/../config/bootstrap.php')();
    /** @var \Closure $routes */
    $routes = require __DIR__ . '/../config/routes.php';

    (new Application($container, $routes))->run();
})();
