<?php


namespace App\Domain\Repository;


use App\Domain\ValueObject\Contact;

class User
{
    private $login;

    private $password;

    /** @var Contact|null */
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return Contact
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }
}