<?php


namespace App\Socket;


abstract class AbstractMessageBody
{
    protected $clientId;

    protected $message;

    protected $secret;

    protected $receiverId;
}