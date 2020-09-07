<?php


namespace App\Domain\Entity;


use App\Domain\ValueObject\IoMessageBody;
use InvalidArgumentException;
use Ratchet\ConnectionInterface;

class IoMessage
{
    /**
     * @var string
     */
    private string $type;

    /**
     * @var array
     */
    private array $body;

    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $author;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @return ConnectionInterface
     */
    public function getAuthor(): ConnectionInterface
    {
        return $this->author;
    }
}
