<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\ValueObject\Contact;

interface ContactRepositoryInterface
{
    public function setContact(int $userId, Contact $contact): bool;
}
