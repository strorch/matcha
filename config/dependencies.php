<?php
declare(strict_types=1);

use App\Application\Migration\MigrationInterface;
use App\Domain\Entity\IoMessage;
use App\Domain\Entity\User;
use App\Domain\Repository\InterestRepository;
use App\Domain\Repository\Interfaces\InterestRepositoryInterface;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserProfileDataRepository;
use App\Domain\Repository\Interfaces\UserProfileDataRepositoryInterface;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\ValueObject\IoMessageBody;
use App\Domain\DTO\UserSearch;
use App\Infrastructure\Hydrator\IoMessageBodyHydrator;
use App\Infrastructure\Hydrator\IoMessageHydrator;
use App\Infrastructure\Hydrator\UserHydrator;
use App\Infrastructure\Hydrator\UserSearchHydrator;
use App\Infrastructure\Mail\MailSender;
use App\Infrastructure\Mail\MailSenderInterface;
use App\Infrastructure\Provider\SettingsProvider;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Infrastructure\Provider\TokenProvider;
use App\Infrastructure\Provider\TokenProviderInterface;
use App\Infrastructure\Provider\UserProvider;
use App\Infrastructure\Provider\UserProviderInterface;
use App\Infrastructure\Validator\Validator;
use App\Infrastructure\Validator\ValidatorInterface;
use App\Socket\BaseSocketManager;
use Dotenv\Exception\InvalidFileException;
use Gamez\Symfony\Component\Serializer\Normalizer\UuidNormalizer;
use hiqdev\DataMapper\Hydrator\ConfigurableHydrator;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Session\SessionProvider;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Middleware\Authentication\JwtAuthentication;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\StreamFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Yiisoft\DataResponse\DataResponseFactory;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Zend\Hydrator\HydratorInterface;

# TODO: try to run with roadrunner

return [
    /**
     * Autowiring
     */
    DataResponseFactoryInterface::class => DI\autowire(DataResponseFactory::class),
    StreamFactoryInterface::class => DI\autowire(StreamFactory::class),
    ResponseFactoryInterface::class => DI\autowire(ResponseFactory::class),
    UserRepositoryInterface::class => DI\autowire(UserRepository::class),
    UserProfileDataRepositoryInterface::class => DI\autowire(UserProfileDataRepository::class),
    TokenProviderInterface::class => DI\autowire(TokenProvider::class),
    UserProviderInterface::class => DI\autowire(UserProvider::class),
    MailSenderInterface::class => DI\autowire(MailSender::class),
    SettingsProviderInterface::class => DI\autowire(SettingsProvider::class),
    InterestRepositoryInterface::class => DI\autowire(InterestRepository::class),
    ValidatorInterface::class => DI\autowire(Validator::class),

    /**
     * Classes definitions
     */
    ServerRequestInterface::class => function (): ServerRequestInterface {
        return ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();
    },
    JwtAuthentication::class => function (ContainerInterface $c, SettingsProviderInterface $settings) {
        return new JwtAuthentication($c, [
            'secret' => $settings->getSettingByName('auth')['secret'] ?? null,
        ]);
    },
    HydratorInterface::class => function (ContainerInterface $c): HydratorInterface {
        return new ConfigurableHydrator($c, [
            IoMessage::class => IoMessageHydrator::class,
            IoMessageBody::class => IoMessageBodyHydrator::class,
            User::class => UserHydrator::class,
            UserSearch::class => UserSearchHydrator::class,
        ]);
    },
//    SerializerInterface::class => function (): SerializerInterface {
//        $encoders = [new JsonEncoder()];
//        $normalizers = [new UuidNormalizer(), new ObjectNormalizer()];
//
//        return new Serializer($normalizers, $encoders);
//    },
    LoggerInterface::class => function (SettingsProviderInterface $settingsProvider): LoggerInterface {
        $loggerSettings = $settingsProvider->getSettingByName('logger');

        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    },
    IoServer::class => function (
        SettingsProviderInterface $settingsProvider,
        BaseSocketManager $baseSocketManager,
        Memcached $memcached
    ): IoServer {
        $socketParams = $settingsProvider->getSettingByName('socket');

        return IoServer::factory(
            new HttpServer(
                new SessionProvider(
                    new WsServer($baseSocketManager),
                    new MemcachedSessionHandler($memcached)
                )
            ),
            $socketParams['port'],
            $socketParams['host'],
        );
    },
    MigrationInterface::class => function (ContainerInterface $c): MigrationInterface {
        return new class($c) implements MigrationInterface {
            /** @var ContainerInterface */
            private ContainerInterface $container;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }
            public function up(): void
            {
                $projectDir = $this->container->get(SettingsProviderInterface::class)
                    ->getSettingByName('projectDir');

                $directory = new \DirectoryIterator($projectDir . '/migrations');
                $regex = new \RegexIterator($directory, '/^.+\.php$/i', \RegexIterator::GET_MATCH);

                foreach ($regex as $item) {
                    $className = "\\App\\migrations\\" . basename(reset($item), '.php');
                    if (!class_exists($className, true)) {
                        throw new InvalidFileException("Class '{$className}' does not exists");
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
];
