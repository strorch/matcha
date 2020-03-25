<?php


namespace App\Socket;


class ChatHandler implements IoHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(IoMessage $message, array $connections)
    {
        var_dump($message->getBody());
    }
}
