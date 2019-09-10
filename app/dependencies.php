<?php
declare(strict_types=1);

use App\Application\Actions\Console\PackDomainsInfoAction;
use App\Application\Actions\Domain\GetDomainInfoAction;
use App\Infrastructure\Provider\MrdpDomainProvider;
use App\Infrastructure\Provider\SettingsProvider;
use App\Infrastructure\Provider\SettingsProviderInterface;
use DI\ContainerBuilder;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\SymfonySerializer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\StreamFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        SettingsProviderInterface::class => function (ContainerInterface $c) {
            return new SettingsProvider($c->get('settings'));
        },
        GetDomainInfoAction::class => DI\autowire(GetDomainInfoAction::class),
        PackDomainsInfoAction::class => DI\autowire(PackDomainsInfoAction::class),
        SerializerInterface::class => DI\autowire(SymfonySerializer::class),
        MrdpDomainProvider::class => DI\autowire(MrdpDomainProvider::class),
        StreamFactoryInterface::class => DI\autowire(StreamFactory::class),
    ]);
};
