<?php


namespace App\Domain\ValueObject;


final class UserSearch
{
    public ?string $username;

    public array $genderIds = [];

    public int $fameRate;

    public ?string $location;
}
