<?php
declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE);

$bootstrap = __DIR__ . '/../src/_bootstrap.php';

require_once file_exists($bootstrap) ? $bootstrap : __DIR__ . '/../vendor/autoload.php';

/*
 * Ensures compatibility with PHPUnit 6.x
 */
if (!class_exists('PHPUnit_Framework_Constraint') && class_exists('PHPUnit\Framework\Constraint\Constraint')) {
    abstract class PHPUnit_Framework_Constraint extends \PHPUnit\Framework\Constraint\Constraint
    {
    }
}
if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('PHPUnit\Framework\TestCase')) {
    abstract class PHPUnit_Framework_TestCase extends \PHPUnit\Framework\TestCase
    {
    }
}
