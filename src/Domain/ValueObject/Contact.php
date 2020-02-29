<?php


namespace App\Domain\ValueObject;


class Contact
{
    /** @var string */
    private $name;

    /** @var string */
    private $lastName;

    /** @var string */
    private $email;

    /** @var string */
    private $gender;

    /** @var string */
    private $about;

    /** @var string[] */
    private $tags;

    /** @var string[] */
    private $pictures;

    /** @var string */
    private $location;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $gender
     * @return Contact
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param string $lastName
     * @return Contact
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param string $name
     * @return Contact
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}