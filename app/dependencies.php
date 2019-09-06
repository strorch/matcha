<?php
declare(strict_types=1);

use App\Application\Actions\Domain\GetDomainInfoAction;
use App\Infrastructure\Provider\MrdpDomainProvider;
use DI\ContainerBuilder;
use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
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
        GetDomainInfoAction::class => function (ContainerInterface $c) {
            $domainInfoDir = $c->get('settings')['domainInfoDir'] ?? '';
            return new GetDomainInfoAction(
                $c->get(StreamFactoryInterface::class),
                $domainInfoDir
            );
        },
        MrdpDomainProvider::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');
            return new MrdpDomainProvider($settings['dbParams']);
        },
        SerializerInterface::class => DI\autowire(SymfonySerializer::class),
        DomainProviderInterface::class => DI\autowire(MrdpDomainProvider::class),
        StreamFactoryInterface::class => DI\autowire(StreamFactory::class),
    ]);
};
