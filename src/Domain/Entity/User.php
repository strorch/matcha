<?php


namespace App\Domain\Entity;


use App\Domain\ValueObject\UserProfileData;

class User
{
    private ?int $id;

    private ?string $username;

    private ?string $email;

    private ?string $lastName;

    private ?string $firstName;

    private ?string $password;

    private bool $isConfirmed = false;

    private ?UserProfileData $profileData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getProfileData(): ?UserProfileData
    {
        return $this->profileData;
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

    public function getIsConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setProfileData(UserProfileData $profileData): self
    {
        $this->profileData = $profileData;

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
