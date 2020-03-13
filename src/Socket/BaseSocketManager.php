<?php


namespace App\Socket;


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
    function onOpen(ConnectionInterface $conn)
    {
        $this->connections[$conn->resourceId] = $conn;
    }

    /**
     * @inheritDoc
     */
    function onClose(ConnectionInterface $conn)
    {
        unset($this->connections[$conn->resourceId]);
    }

    /**
     * @inheritDoc
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->logger->error($e->getMessage());

        $conn->send(json_encode(['error' => $e->getMessage()]));

        $conn->close();
    }

    /**
     * @inheritDoc
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        echo $msg;

//        $this->handler->handle($msg);

        $from->send($msg);
    }
}