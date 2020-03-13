<?php


namespace App\Socket;


use InvalidArgumentException;

class SocketMessageHandler
{
//    protected function get

    public function handle(string $message)
    {
        $messageBody = json_decode($message, true);
        if (!is_array($messageBody) || !is_string($messageBody[0]) || !is_array($messageBody[1])) {
            throw new InvalidArgumentException("Invalid message body");
        }


    }
}