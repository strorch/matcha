<?php


namespace App\Socket;


class IoMessageBody
{
    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $receiverId;

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getReceiverId(): string
    {
        return $this->receiverId;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $receiverId
     * @return $this
     */
    public function setReceiverId(string $receiverId): self
    {
        $this->receiverId = $receiverId;

        return $this;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @param string $clientId
     * @return $this
     */
    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
