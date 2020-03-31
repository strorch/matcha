<?php


namespace App\Infrastructure\Hydrator;


use GeneratedHydrator\Configuration;
use Zend\Hydrator\HydratorInterface;

abstract class AbstractHydrator implements HydratorInterface
{
    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var HydratorInterface[]
     */
    protected $generatedHydrators = [];

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param object $object
     * @return HydratorInterface
     */
    protected function getGeneratedHydrator($object): HydratorInterface
    {
        $class = get_class($object);
        if (empty($this->generatedHydrators[$class])) {
            $config = new Configuration($class);
            $hydratorClass = $config->createFactory()->getHydratorClass();

            $this->generatedHydrators[$class] = new $hydratorClass();
        }

        return $this->generatedHydrators[$class];
    }

    public function hydrate(array $data, $object)
    {
        return $this->getGeneratedHydrator($object)->hydrate($data, $object);
    }

    /**
     * @param string $className
     * @param array $data
     * @return object
     * @throws \ReflectionException
     */
    public function createEmptyInstance(string $className, array $data = [])
    {
        $reflection = new \ReflectionClass($className);

        return $reflection->newInstanceWithoutConstructor();
    }
}
