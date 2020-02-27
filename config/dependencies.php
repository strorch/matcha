<?php
declare(strict_types=1);

use App\Application\Migration\MigrationInterface;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\DB\DB;
use App\Infrastructure\Provider\SettingsProvider;
use App\Infrastructure\Provider\SettingsProviderInterface;
use App\Socket\Client\SocketClient;
use App\Socket\Managers\ChatManager;
use App\Socket\Managers\NotificationManager;
use App\Socket\Servers\ChatServer;
use App\Socket\Servers\NotificationServer;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Http\Router;
use Ratchet\Server\IoServer;
use Slim\Psr7\Factory\StreamFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

return static function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        /**
         * Autowiring
         */
        SessionInterface::class => DI\autowire(Session::class),
        StreamFactoryInterface::class => DI\autowire(StreamFactory::class),
        ChatManager::class => DI\autowire(ChatManager::class),
        NotificationManager::class => DI\autowire(NotificationManager::class),
        ChatServer::class => DI\autowire(ChatServer::class),
        NotificationServer::class => DI\autowire(NotificationServer::class),
        UserRepositoryInterface::class => DI\autowire(UserRepository::class),
        SocketClient::class => DI\autowire(SocketClient::class),

        /**
         * Classes definitions
         */
        LoggerInterface::class => function (ContainerInterface $c): LoggerInterface {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
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
        IoServer::class => function (SettingsProviderInterface $settingsProvider, ChatServer $chat, NotificationServer $notification): IoServer {
            $socketParams = $settingsProvider->getSettingByName('socket');

            $collection = new RouteCollection();
            $collection->add('notify', new Route('/notify', ['_controller' => $notification]));
            $collection->add('chat', new Route('/chat', ['_controller' => $chat]));

            $urlMatcher = new UrlMatcher($collection, new RequestContext());
            $router = new Router($urlMatcher);

            return IoServer::factory(new HttpServer($router), $socketParams['port'], $socketParams['host']);
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
