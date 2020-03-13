<?php


namespace App\Socket\Managers;


use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ChatManager implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    /**
     * @inheritDoc
     */
    public function onOpen(ConnectionInterface $conn, RequestInterface $request = null)
    {
        $this->clients->attach($conn);

        print "\nChat Opened!!!!";
        $conn->send('welcome');
    }

    /**
     * @inheritDoc
     */
    public function onClose(ConnectionInterface $conn)
    {
        print "\nChat closed!!!!";
        $conn->send('closed');
    }

    /**
     * @inheritDoc
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        print "\nerrror!!!!";
        $conn->send('errror');
    }

    /**
     * @inheritDoc
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        print "Message recieved: " . (string)$msg;
        $from->send('Your message: ' . (string)$msg);
    }
}
