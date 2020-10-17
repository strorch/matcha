<?php


namespace App\Domain\Entity;


use App\Domain\ValueObject\Contact;

class User
{
    private ?int $id;

    private ?string $username;

    private ?string $email;

    private ?string $lastName;

    private ?string $firstName;

    private ?string $password;

    private bool $isConfirmed = false;

    private ?Contact $contact;

    private int $fameRate = 0;

    private array $fakeAccounts = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFameRate(): ?int
    {
        return $this->fameRate;
    }

    public function getFakeAccounts(): array
    {
        return $this->fakeAccounts;
    }

    public function getIsConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function addFameRate(): self
    {
        $this->fameRate += 1;

        return $this;
    }

    public function addFakeAccounts(User $fakeAccounts): self
    {
        $this->fakeAccounts[] = $fakeAccounts;

        return $this;
    }

    public function setEmailConfirmed(): self
    {
        $this->isConfirmed = true;

        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
