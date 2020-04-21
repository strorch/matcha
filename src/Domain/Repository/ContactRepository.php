<?php


namespace App\Domain\Repository;


use App\Domain\Repository\Interfaces\ContactRepositoryInterface;
use App\Domain\ValueObject\Contact;

class ContactRepository extends AbstractRepository implements ContactRepositoryInterface
{
    public function setContact(int $userId, Contact $contact): bool
    {
        return true;
    }
}
