<?php


namespace App\Socket;


use Ratchet\ConnectionInterface;

interface IoHandlerInterface
{
    /**
     * @param IoMessage $message
     * @param ConnectionInterface[] $connections
     * @return mixed
     */
    public function handle(IoMessage $message, array $connections);
}