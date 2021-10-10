<?php
declare(strict_types=1);

namespace App\Infrastructure\Hydrator;


use App\Domain\ValueObject\IoMessageBody;
use hiqdev\DataMapper\Hydrator\GeneratedHydrator;

class IoMessageBodyHydrator extends GeneratedHydrator
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
