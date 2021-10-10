<?php
declare(strict_types=1);

namespace App\Infrastructure\Hydrator;


use App\Domain\Entity\User;
use App\Domain\ValueObject\UserProfileData;
use hiqdev\DataMapper\Hydrator\GeneratedHydrator;
use Ramsey\Uuid\Uuid;

/**
 * Class UserHydrator
 * @package App\Infrastructure\Hydrator
 */
class UserHydrator extends GeneratedHydrator
{
    /**
     * @param string|object $object
     * @return object|User
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        $data['profileData'] = $data['profileData'] ?? new UserProfileData();
        $data['id'] = $data['id'] ?? Uuid::uuid4();
        $data['passwordHash'] = $data['passwordHash'] ?? (string)password_hash($data['password'], PASSWORD_BCRYPT);

        return parent::hydrate($data, $object);
    }

    /**
     * @param object|User $object
     * @inheritDoc
     */
    public function extract($object)
    {
        return [
            'id'            => $object->getId(),
            'username'      => $object->getUsername(),
            'email'         => $object->getEmail(),
            'lastName'      => $object->getLastName(),
            'firstName'     => $object->getFirstName(),
            'isConfirmed'   => $object->getIsConfirmed(),
            'profileData'   => $object->getProfileData(),
        ];
    }
}
