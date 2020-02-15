<?php


namespace App\Socket\Managers;


use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class NotificationManager implements MessageComponentInterface
{
    /**
     * @inheritDoc
     */
    public function onOpen(ConnectionInterface $conn)
    {
        print "\nNotify Opened!!!!";
        $conn->send('welcome');
    }

    /**
     * @inheritDoc
     */
    public function onClose(ConnectionInterface $conn)
    {
        print "\nNotify clsoed";
    }

    /**
     * @inheritDoc
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    /**
     * @inheritDoc
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $from->send('your: ' . $msg);
    }
}