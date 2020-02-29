<?php


namespace App\Domain\Repository;


use App\Domain\ValueObject\Contact;

class User
{
    /** @var int */
    private $id;

    /** @var string */
    private $login;

    /** @var string */
    private $password;

    /** @var Contact */
    private $contact;

    /** @var int */
    private $rating;

    /** @var User[] */
    private $blockedUsers;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param Contact $contact
     * @return User
     */
    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}