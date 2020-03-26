<?php


namespace App\Domain\Entity;


use App\Domain\ValueObject\Contact;

class User
{
    /** @var int|null */
    private $id;

    /** @var string|null */
    private $username;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $lastName;

    /** @var string|null */
    private $firstName;

    /** @var string|null */
    private $password;

    /** @var Contact|null */
    private $contact;

    /** @var User[] */
    private $blockedUsers = [];

    /** @var int|null */
    private $fameRate;

    /** @var string[] */
    private $fakeAccounts = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return int|null
     */
    public function getFameRate(): ?int
    {
        return $this->fameRate;
    }

    /**
     * @return string[]
     */
    public function getFakeAccounts(): array
    {
        return $this->fakeAccounts;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param User $blockedUser
     * @return $this
     */
    public function addBlockedUsers(User $blockedUser): self
    {
        $this->blockedUsers[] = $blockedUser;

        return $this;
    }

    /**
     * @return $this
     */
    public function addFameRate(): self
    {
        $this->fameRate += 1;

        return $this;
    }

    /**
     * @param User $fakeAccounts
     * @return $this
     */
    public function addFakeAccounts(User $fakeAccounts): self
    {
        $this->fakeAccounts = $fakeAccounts;

        return $this;
    }
}
