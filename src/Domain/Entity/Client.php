<?php


namespace App\Domain\Repository;


use App\Domain\ValueObject\Contact;

class Client
{
    private $login;

    private $password;

    /** @var Contact */
    private $contact;

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     * @return Client
     */
    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}