<?php


namespace App\Domain\Entity;


use App\Domain\ValueObject\IoMessageBody;
use InvalidArgumentException;
use Ratchet\ConnectionInterface;

class IoMessage
{
    private string $type;

    private array $body;

    private ConnectionInterface $author;

    public function getType(): string
    {
        return $this->type;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getAuthor(): ConnectionInterface
    {
        return $this->author;
    }
}
