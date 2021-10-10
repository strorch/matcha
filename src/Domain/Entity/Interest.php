<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Interest
{
    public UuidInterface $id;

    public string $name;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
