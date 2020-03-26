<?php


namespace App\Socket;


use App\Domain\Entity\IoMessage;

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
