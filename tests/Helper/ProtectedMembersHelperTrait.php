<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use ReflectionClass;
use ReflectionException;

trait ProtectedMembersHelperTrait
{
    /**
     * @throws ReflectionException
     */
    protected function invokeProtectedMethod($object, string $methodName, array $args = [])
    {
        $reflection = new ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }

    /**
     * @throws ReflectionException
     */
    protected function getProtectedProperty($object, string $propertyName)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * @throws ReflectionException
     */
    protected function setProtectedProperty($object, string $propertyName, $value): void
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
