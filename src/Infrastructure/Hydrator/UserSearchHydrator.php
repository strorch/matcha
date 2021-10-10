<?php
declare(strict_types=1);

namespace App\Infrastructure\Hydrator;


use App\Domain\DTO\UserSearch;
use hiqdev\DataMapper\Hydrator\GeneratedHydrator;

/**
 * Class UserHydrator
 * @package App\Infrastructure\Hydrator
 */
class UserSearchHydrator extends GeneratedHydrator
{
    /**
     * @param $object object|string
     * @return UserSearch|object
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        return parent::hydrate($data, $object);
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
    }
}
