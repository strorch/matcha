<?php


namespace Tests\Unit;


use Psr\Container\ContainerInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    private ContainerInterface $container;

    public function getDi(): ContainerInterface
    {
        if (empty($this->container)) {
            $this->container = (require __DIR__ . '/../../config/bootstrap.php')();
        }

        return $this->container;
    }
}
