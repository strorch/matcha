<?php

namespace App\Infrastructure\Hydrator\Lib;

use Psr\Container\ContainerInterface;
use Zend\Hydrator\ExtractionInterface;
use Zend\Hydrator\HydrationInterface;
use Zend\Hydrator\HydratorInterface;

class ConfigurableAggregateHydrator implements HydratorInterface
{
    /**
     * @var HydrationInterface[]
     */
    private array $hydrators = [];

    private ContainerInterface $di;

    public function __construct(ContainerInterface $di, array $hydrators = [])
    {
        $this->di = $di;
        $this->hydrators = $hydrators;
    }

    /**
     * @return HydrationInterface|ExtractionInterface
     */
    protected function getHydrator(string $className)
    {
        if (!isset($this->hydrators[$className])) {
            throw new \Exception('Hydrator for "' . $className . '" is not configured');
        }
        if (!is_object($this->hydrators[$className])) {
            $this->hydrators[$className] = $this->di->get($this->hydrators[$className]);
        }

        return $this->hydrators[$className];
    }

    /**
     * Create new object of given class with the provided $data.
     * When given $data is object just returns it.
     * @param object|array $data
     * @param string $class class name
     * @return object
     * @throws \Exception
     */
    public function create($data, $class)
    {
        return is_object($data) ? $data : $this->hydrate(is_array($data) ? $data : [$data], $class);
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param array $data
     * @param object|string $object object or class name
     * @return object
     * @throws \Exception
     */
    public function hydrate(array $data, $object)
    {
        if (is_object($object)) {
            $hydrator = $this->getHydrator(get_class($object));
        } else {
            $hydrator = $this->getHydrator($object);
            $object = $hydrator->createEmptyInstance($object, $data);
        }

        return $hydrator->hydrate($data, $object);
    }

    /**
     * Extract values from an object.
     *
     * @param object $object
     * @return array
     * @throws \Exception
     */
    public function extract($object)
    {
        return $this->getHydrator(get_class($object))->extract($object);
    }

    /**
     * Extract multiple objects.
     * @param array $array
     * @param int $depth
     * @return array
     * @throws \Exception
     */
    public function extractAll(array $array, int $depth = 1)
    {
        $depth--;
        $res = [];
        foreach ($array as $key => $object) {
            $res[$key] = $depth>0 ? $this->extractAll($object, $depth) : $this->extract($object);
        }

        return $res;
    }
}
