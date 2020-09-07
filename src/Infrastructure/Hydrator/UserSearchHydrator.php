<?php


namespace App\Infrastructure\Hydrator;


use App\Infrastructure\Hydrator\Lib\AbstractHydrator;

/**
 * Class UserHydrator
 * @package App\Infrastructure\Hydrator
 */
class UserSearchHydrator extends AbstractHydrator
{
    /**
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
