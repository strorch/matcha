<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Socket;


use App\Domain\Entity\IoMessage;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Zend\Hydrator\HydratorInterface;

final class BaseSocketManager implements MessageComponentInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var IoMessageTypeResolver
     */
    private IoMessageTypeResolver $handler;

    /**
     * @var \SplObjectStorage|ConnectionInterface[]
     */
    private $connections;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    public function __construct(
        LoggerInterface $logger,
        IoMessageTypeResolver $handler,
        HydratorInterface $hydrator
    ) {
        $this->logger = $logger;
        $this->handler = $handler;
        $this->hydrator = $hydrator;
        $this->connections = new \SplObjectStorage();
    }

    /**
     * @inheritDoc
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $conn->Session->start();
        $this->connections->attach($conn);
    }

    /**
     * @inheritDoc
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
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
        /** @var Session $session */
        $session = $from->Session;
        var_dump($session->get('user'));

        $message = IoMessage::create($from, $msg);

        $this->handler->handle($message, $this->connections);
    }
}
