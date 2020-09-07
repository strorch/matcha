<?php


namespace App\Infrastructure\Hydrator;


use App\Domain\Entity\IoMessage;
use App\Domain\ValueObject\IoMessageBody;
use App\Infrastructure\Hydrator\Lib\AbstractHydrator;
use InvalidArgumentException;

class IoMessageHydrator extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @param IoMessage|string $object
     */
    public function hydrate(array $data, $object)
    {
        $messageArray = json_decode($messageString, true);
        if (!is_array($messageArray) || !is_string($messageArray[0] ?? null) || !is_array($messageArray[1] ?? null)) {
            throw new InvalidArgumentException("Invalid message body");
        }
        // TODO: refactor with hydrator
        $ioMessageBody = new IoMessageBody();
//        $ioMessageBody->message = $messageArray[]

        $static->setType($messageArray[0]);
        $static->setBody($this->hydrator->hydrate($messageArray[1], IoMessageBody::class));

        return parent::hydrate($data, $object);
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
    }
}
