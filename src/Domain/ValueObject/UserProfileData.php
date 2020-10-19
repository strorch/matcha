<?php


namespace App\Domain\ValueObject;


class UserProfileData
{
    public int $userId;

    public string $gender;

    public string $biography;

    public array $interests;

    public array $pictures;

    public string $location;

    public int $age;

    private int $fameRate = 0;

    private array $fakeAccounts = [];
}
