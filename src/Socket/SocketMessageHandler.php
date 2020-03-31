<?php


namespace App\Socket;


use App\Domain\Entity\IoMessage;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class SocketMessageHandler implements IoHandlerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $type
     * @return IoHandlerInterface
     */
    private function getHandler(string $type): IoHandlerInterface
    {
        $handlers = [
            'chat' => ChatHandler::class,
            'notification' => NotificationHandler::class,
        ];

        if (empty($handlers[$type])) {
            throw new InvalidArgumentException('wrong message type');
        }

        return $this->container->get($handlers[$type]);
    }

    /**
     * @inheritDoc
     */
    public function handle(IoMessage $message, array $connections)
    {
        $handler = $this->getHandler($message->getType());

        return $handler->handle($message, $connections);
    }
}
