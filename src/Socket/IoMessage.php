<?php


namespace App\Socket;


use InvalidArgumentException;
use Ratchet\ConnectionInterface;

class IoMessage
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $body;

    /**
     * @var ConnectionInterface
     */
    private $author;

    public static function create(ConnectionInterface $author, string $message): self
    {
        $static = new static();

        $messageBody = json_decode($message, true);
        if (!is_array($messageBody) || !is_string($messageBody[0]) || !is_array($messageBody[1])) {
            throw new InvalidArgumentException("Invalid message body");
        }

        $static->setType($messageBody[0]);
        $static->setBody($messageBody[1]);
        $static->setAuthor($author);

        return $static;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

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

    /**
     * @param ConnectionInterface $author
     */
    public function setAuthor(ConnectionInterface $author): void
    {
        $this->author = $author;
    }
}