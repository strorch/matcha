<?php


namespace App\Domain\ValueObject;


final class UserSearch
{
    public ?string $username;

    public ?string $password;

    public ?string $additionalPassword;

    public ?string $location;
}
