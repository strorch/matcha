<?php


namespace App\Socket;


use App\Domain\Entity\IoMessage;

class NotificationHandler implements IoHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(IoMessage $message, \SplObjectStorage $connections)
    {
        var_dump($message->getAuthor()->resourceId);
    }
}
