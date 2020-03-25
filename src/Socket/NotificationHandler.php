<?php


namespace App\Socket;


class NotificationHandler implements IoHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(IoMessage $message, array $connections)
    {
        var_dump($message->getAuthor()->resourceId);
    }
}
