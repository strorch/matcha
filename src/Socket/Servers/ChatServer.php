<?php


namespace App\Socket\Servers;


use App\Socket\Managers\ChatManager;
use Ratchet\WebSocket\WsServer;

class ChatServer extends WsServer
{
    public function __construct(ChatManager $component)
    {
        parent::__construct($component);
    }
}