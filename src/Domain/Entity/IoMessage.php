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
    private $type;

    /**
     * @var array
     */
    private $body;

    /**
     * @var ConnectionInterface
     */
    private $author;

    public static function create(ConnectionInterface $author, string $messageString): self
    {
        $static = new static();

        $messageArray = json_decode($messageString, true);
        if (!is_array($messageArray) || !is_string($messageArray[0] ?? null) || !is_array($messageArray[1] ?? null)) {
            throw new InvalidArgumentException("Invalid message body");
        }

        $ioMessageBody = new IoMessageBody();
//        $ioMessageBody->message = $messageArray[]

        $static->setType($messageArray[0]);
        $static->setBody($messageArray[1]);
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
