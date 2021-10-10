<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\UserProfileData;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class User
{
    private UuidInterface $id;

    private string $username;

    private string $email;

    private string $lastName;

    private string $firstName;

    private string $passwordHash;

    private bool $isConfirmed = false;

    private ?UserProfileData $profileData = null;

    public function __construct(
        string $username,
        string $email,
        string $lastName,
        string $firstName,
        string $passwordHash
    ) {
        $this->id = Uuid::uuid4();
        $this->username = $username;
        $this->email = $email;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->passwordHash = $passwordHash;
    }

    public function getId(): UuidInterface
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

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
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

    public function setProfileData(?UserProfileData $profileData): self
    {
        $this->profileData = $profileData;

        return $this;
    }

    public function setEmailConfirmed(): self
    {
        $this->isConfirmed = true;

        return $this;
    }
}
