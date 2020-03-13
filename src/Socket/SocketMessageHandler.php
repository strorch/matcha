<?php


namespace App\Socket;


class SocketMessageHandler
{
    public function handle(string $message)
    {
        $messageBody = json_decode($message, true);
    }
}