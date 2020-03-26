<?php


namespace App\Domain\ValueObject;


class IoMessageBody
{
    /** @var string */
    public $clientId;

    /** @var string */
    public $receiverId;

    /** @var string */
    public $message;

    /** @var string */
    public $secret;
}
