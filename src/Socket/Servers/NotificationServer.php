<?php


namespace App\Socket\Servers;


use App\Socket\Managers\NotificationManager;
use Ratchet\WebSocket\WsServer;

class NotificationServer extends WsServer
{
    public function __construct(NotificationManager $component)
    {
        parent::__construct($component);
    }
}