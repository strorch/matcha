<?php


namespace App\Infrastructure\Hydrator;


use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\Hydrator\Lib\AbstractHydrator;

/**
 * Class UserHydrator
 * @package App\Infrastructure\Hydrator
 */
class UserSearchHydrator extends AbstractHydrator
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
