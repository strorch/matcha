<?php


namespace App\Domain\ValueObject;


class Contact
{
    /** @var int */
    public $userId;

    /** @var string */
    public $gender;

    /** @var string */
    public $biography;

    /** @var string[] */
    public $interests;

    /** @var string[] */
    public $pictures;

    /** @var string */
    public $location;

    /** @var int */
    public $age;
}
