<?php


namespace App\Domain\ValueObject;


class IoMessageBody
{
    /** @var string */
    public string $clientId;

    /** @var string */
    public string $receiverId;

    /** @var string */
    public string $message;

    /** @var string */
    public string $secret;
}
