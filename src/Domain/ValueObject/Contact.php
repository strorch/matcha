<?php


namespace App\Domain\ValueObject;


class Contact
{
    /** @var string */
    public string $gender;

    /** @var string */
    public string $biography;

    /** @var string[] */
    public array $interests;

    /** @var string[] */
    public array $pictures;

    /** @var string */
    public string $location;

    /** @var int */
    public int $age;
}
