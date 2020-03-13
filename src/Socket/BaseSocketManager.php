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
     * @var string[]
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
        echo 'opened';
        $conn->send('opened');
    }

    /**
     * @inheritDoc
     */
    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
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

        $this->handler->handle($msg);

        $from->send($msg);
    }
}