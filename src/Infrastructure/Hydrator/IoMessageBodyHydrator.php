<?php


namespace App\Infrastructure\Hydrator;


use App\Domain\ValueObject\IoMessageBody;
use App\Infrastructure\Hydrator\Lib\AbstractHydrator;

class IoMessageBodyHydrator extends AbstractHydrator
{
    /**
     * @inheritDoc
     * @param string|IoMessageBody $object
     *
     * @return IoMessageBody|object
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
