<?php


namespace App\Socket\Client;


final class SocketClient
{
    public function sendNotify()
    {
        $loop = \React\EventLoop\Factory::create();
        $connector = new \React\Socket\Connector($loop);

        $connector->connect('0.0.0.0:8000')->then(function (\React\Socket\ConnectionInterface $connection) {
            $connection->write('HELLO');
            $connection->end();
        });

        $loop->run();
    }
}