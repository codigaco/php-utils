<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Unit\ReflectionUtils;

use Codigaco\PhpUtils\ReflectionUtils;
use Codigaco\PhpUtils\Tests\Providers\ChildFoo;
use Codigaco\PhpUtils\Tests\Providers\ParentFoo;
use Codigaco\PhpUtils\Tests\Providers\PublicFoo;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;

/** @see ReflectionUtils::getProperties() */
class ReflectionUtilsGetPropertyTest extends TestCase
{
    public function testPropertyDoesNotExist(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::getProperty(PublicFoo::class, 'kk');
    }

    /** @dataProvider provider */
    public function testGetProperty(
        ReflectionProperty $reflectionProperty,
        string $className,
        string $propertyName
    ): void {
        !class_exists($className) && $this->expectException(ReflectionException::class);
        $property = ReflectionUtils::getProperty($className, $propertyName ?? '');
        class_exists($className) && self::assertEquals($reflectionProperty, $property);
    }

    public function provider(): iterable
    {
        yield 'getPropery' => [
            new ReflectionProperty(PublicFoo::class, 'id'),
            PublicFoo::class,
            'id'
        ];

        yield 'getParentProperty' => [
            new ReflectionProperty(ParentFoo::class, 'id'),
            ChildFoo::class,
            'id',
        ];

        yield 'getEmbebedPropery' => [
            new ReflectionProperty(ParentFoo::class, 'id'),
            PublicFoo::class,
            'privateFoo.childFoo.id',
        ];

        yield 'classNotFound' => [
            new ReflectionProperty(PublicFoo::class, 'id'),
            'kk',
            'id',
        ];
    }
}
