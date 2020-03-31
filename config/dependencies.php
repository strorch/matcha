<?php
declare(strict_types=1);

use App\Application\Migration\MigrationInterface;
use App\Domain\Entity\IoMessage;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\ValueObject\IoMessageBody;
use App\Infrastructure\DB\DB;
use App\Infrastructure\Hydrator\ConfigurableAggregateHydrator;
use App\Infrastructure\Hydrator\IoMessageBodyHydrator;
use App\Infrastructure\Hydrator\IoMessageHydrator;
use App\Infrastructure\Mail\CustomMessageFactory;
use App\Infrastructure\Provider\SettingsProvider;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Socket\BaseSocketManager;
use App\Socket\ChatHandler;
use App\Socket\NotificationHandler;
use App\Socket\SocketMessageHandler;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Slim\Psr7\Factory\StreamFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Zend\Hydrator\HydratorInterface;

return static function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        /**
         * Autowiring
         */
        StreamFactoryInterface::class => DI\autowire(StreamFactory::class),
        BaseSocketManager::class => DI\autowire(BaseSocketManager::class),
        UserRepositoryInterface::class => DI\autowire(UserRepository::class),
        CustomMessageFactory::class => DI\autowire(CustomMessageFactory::class),
        SocketMessageHandler::class => DI\autowire(SocketMessageHandler::class),
        ChatHandler::class => DI\autowire(ChatHandler::class),
        NotificationHandler::class => DI\autowire(NotificationHandler::class),
        HydratorInterface::class => DI\autowire(ConfigurableAggregateHydrator::class),

        /**
         * Classes definitions
         */
        SessionInterface::class => function (Memcached $memcached): SessionInterface {
            $sessionStorage = new NativeSessionStorage([], new MemcachedSessionHandler($memcached));

            return new Session($sessionStorage);
        },
        Memcached::class => function (SettingsProviderInterface $provider): Memcached {
            $memData = $provider->getSettingByName('memcached');

            $memcached = new \Memcached;
            $memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
            $memcached->addServer($memData['host'], $memData['port']);

            return $memcached;
        },
        Swift_Mailer::class => function (SettingsProviderInterface $settingsProvider): Swift_Mailer {
            $settings = $settingsProvider->getSettingByName('mail');

            $transport = (new Swift_SmtpTransport($settings['host'], $settings['port']))
                ->setUsername($settings['login'])
                ->setPassword($settings['password']);

            return new Swift_Mailer($transport);
        },
        ConfigurableAggregateHydrator::class => function (ContainerInterface $c): ConfigurableAggregateHydrator {
            return new ConfigurableAggregateHydrator($c, [
                IoMessage::class => IoMessageHydrator::class,
                IoMessageBody::class => IoMessageBodyHydrator::class,
            ]);
        },
        SerializerInterface::class => function (): SerializerInterface {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            return new Serializer($normalizers, $encoders);
        },
        LoggerInterface::class => function (SettingsProviderInterface $settingsProvider): LoggerInterface {
            $loggerSettings = $settingsProvider->getSettingByName('logger');

            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        SettingsProviderInterface::class => function (ContainerInterface $c): SettingsProviderInterface {
            return new SettingsProvider($c->get('settings'));
        },
        DB::class => function (SettingsProviderInterface $settingsProvider): DB {
            return DB::get($settingsProvider->getSettingByName('dbParams'));
        },
        IoServer::class => function (SettingsProviderInterface $settingsProvider, BaseSocketManager $baseSocketManager): IoServer {
            $socketParams = $settingsProvider->getSettingByName('socket');

            return IoServer::factory(new HttpServer(new WsServer($baseSocketManager)), $socketParams['port'], $socketParams['host']);
        },
        MigrationInterface::class => function (ContainerInterface $c): MigrationInterface {
            return new class($c) implements MigrationInterface {
                /** @var ContainerInterface */
                private $container;

                public function __construct(ContainerInterface $container)
                {
                    $this->container = $container;
                }
                public function up(): void
                {
                    $directory = new \DirectoryIterator('migrations');
                    $regex = new \RegexIterator($directory, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

                    foreach ($regex as $item) {
                        $className = "\\App\\migrations\\" . basename(reset($item), '.php');
                        if (!class_exists($className, true)) {
                            throw new \Dotenv\Exception\InvalidFileException("Class '{$className}' does not exists");
                        }
                        /** @var MigrationInterface $migration */
                        $migration = $this->container->get($className);
                        $migration->up();
                    }
                }
                public function down(): void
                {
                }
            };
        },
    ]);
};
