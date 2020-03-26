<?php


namespace App\Domain\ValueObject;


final class UserSearch
{
    /** @var string|null */
    public $username;

    /** @var string|null */
    public $password;

    /** @var string|null */
    public $additionalPassword;

    /** @var string|null */
    public $location;
}
