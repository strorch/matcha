<?php


namespace App\Domain\ValueObject;


final class UserSearch
{
    /** @var string|null */
    public ?string $username;

    /** @var string|null */
    public ?string $password;

    /** @var string|null */
    public ?string $additionalPassword;

    /** @var string|null */
    public ?string $location;
}
