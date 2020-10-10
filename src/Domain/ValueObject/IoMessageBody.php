<?php


namespace App\Domain\ValueObject;


class IoMessageBody
{
    public string $clientId;

    public string $receiverId;

    public string $message;

    public string $secret;
}
