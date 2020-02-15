<?php
declare(strict_types=1);

use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Socket\ChatManager;
use App\Socket\NotificationManager;

require __DIR__ . '/../vendor/autoload.php';

(static function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = (require __DIR__ . '/../config/bootstrap.php')();

    $settingsProvider = $container->get(SettingsProviderInterface::class);
    $socketParams = $settingsProvider->getSettingByName('socket');


    $chatManager = $container->get(ChatManager::class);
    $notificationManager = $container->get(NotificationManager::class);
})();
