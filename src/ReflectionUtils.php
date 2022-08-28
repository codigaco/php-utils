<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ReflectionProperty;

class ReflectionUtils
{
    /** @throws ReflectionException */
    public static function getProperty(string $class, string $path): ReflectionProperty
    {
        $reflection = new ReflectionClass($class);

        [$name, $nextPath] = explode('.', $path, 2);

        if ($reflection->hasProperty($name)) {
            return isset($nextPath)
                ? self::getProperty(self::propertyType($class, $name), $nextPath)
                : $reflection->getProperty($name);
        }

        if ($parentClass = $reflection->getParentClass()) {
            return self::getProperty($parentClass->getName(), $name);
        }

        throw new ReflectionException(sprintf('property %s not found %s', $path, $class));
    }

    /**
     * @return ReflectionProperty[]
     * @throws ReflectionException
     */
    public static function getProperties(string $className): array
    {
        $reflection = new ReflectionClass($className);
        $parentClass = $reflection->getParentClass();

        if (false === $parentClass) {
            return $reflection->getProperties();
        }

        return array_merge($reflection->getProperties(), self::getProperties($parentClass->getName()));
    }

    /** @throws ReflectionException */
    public static function newInstanceWithProperties(string $class, array $attributes): object
    {
        $reflection = new ReflectionClass($class);
        $attributes += $reflection->getStaticProperties();
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach (self::getProperties($class) as $property) {
            self::setProperty($instance, $property->getName(), $attributes[$property->getName()] ?? null);
        }

        return $instance;
    }

    /** @throws ReflectionException */
    public static function newInstanceWithConstructor(string $class, array $attributes): object
    {
        $reflection = new ReflectionClass($class);

        if ($reflection->getConstructor() === null) {
            return new $class();
        }

        $arguments = array_map(static function (ReflectionParameter $parameter) use ($attributes) {
            return $attributes[$parameter->getName()] ?? null;
        }, $reflection->getConstructor()->getParameters());

        return $reflection->newInstanceArgs($arguments);
    }

    /** @throws ReflectionException */
    public static function setProperty(object $instance, string $key, $value): void
    {
        $property = self::getProperty(get_class($instance), $key);
        $isPublic = $property->isPublic();
        if (!$isPublic) {
            $property->setAccessible(true);
        }

        $property->setValue($instance, $value);

        if (!$isPublic) {
            $property->setAccessible(false);
        }
    }

    /** @throws ReflectionException */
    public static function propertyType(string $class, string $route): string
    {
        $property = self::getProperty($class, $route);

        if (null !== $property->getType()) {
            return $property->getType()->getName();
        }

        $annotations = $property->getDocComment();

        if ($annotations && preg_match('/@var ([^\n\s]+)/', $annotations, $matches)) {
            preg_match_all('/(\w+)/', $matches[1], $typesFound);
            [, $types] = $typesFound;

            return $types[0];
        }

        throw new ReflectionException(sprintf('Undefined type of %s in %s', $route, $class));
    }

    /** @throws ReflectionException */
    public static function isNullable(string $class, string $route): bool
    {
        $property = self::getProperty($class, $route);

        if (null !== $property->getType()) {
            return !$property->hasType() || $property->getType()->allowsNull();
        }

        $annotations = $property->getDocComment();

        if ($annotations && preg_match('/@var ([^\n\s]+)/', $annotations, $matches)) {
            preg_match_all('/(\w+)/', $matches[1], $typesFound);
            [, $types] = $typesFound;

            return in_array('null', $types, true);
        }

        return true;
    }
}
