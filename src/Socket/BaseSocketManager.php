<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Socket;


use App\Domain\Entity\IoMessage;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

final class BaseSocketManager implements MessageComponentInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SocketMessageHandler
     */
    private $handler;

    /**
     * @var ConnectionInterface[]
     */
    private $connections = [];

    public function __construct(LoggerInterface $logger, SocketMessageHandler $handler)
    {
        $this->logger = $logger;
        $this->handler = $handler;
    }

    /**
     * @inheritDoc
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections[$conn->resourceId] = $conn;
    }

    /**
     * @inheritDoc
     */
    public function onClose(ConnectionInterface $conn)
    {
        unset($this->connections[$conn->resourceId]);
    }

    /**
     * @inheritDoc
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->logger->error($e->getMessage());
        $conn->send(json_encode(['error' => $e->getMessage()]));
    }

    /**
     * @inheritDoc
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = IoMessage::create($from, $msg);

        $this->handler->handle($message, $this->connections);
    }
}
