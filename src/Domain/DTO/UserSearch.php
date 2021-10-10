<?php


namespace App\Domain\DTO;


final class UserSearch
{
    public ?string $username;

    public array $genderIds = [];

    public int $fameRate;

    public ?string $location;
}
