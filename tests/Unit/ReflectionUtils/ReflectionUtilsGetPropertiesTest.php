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
class ReflectionUtilsGetPropertiesTest extends TestCase
{
    /** @dataProvider provider */
    public function testGetPropertie(array $expected, string $className): void
    {
        !class_exists($className) && $this->expectException(ReflectionException::class);
        $properties = ReflectionUtils::getProperties($className);
        class_exists($className) && self::assertEquals($expected, $properties);
    }

    public function provider(): iterable
    {
        yield 'PublicClassProperties' => [
            [
                new ReflectionProperty(PublicFoo::class, 'id'),
                new ReflectionProperty(PublicFoo::class, 'name'),
                new ReflectionProperty(PublicFoo::class, 'privateFoo'),
                new ReflectionProperty(PublicFoo::class, 'withDocType'),
                new ReflectionProperty(PublicFoo::class, 'withoutType'),
            ],
            PublicFoo::class,
        ];
        yield 'ChildAndParentProperties' => [
            [
                new ReflectionProperty(ChildFoo::class, 'name'),
                new ReflectionProperty(ParentFoo::class, 'id'),
            ],
            ChildFoo::class,
        ];
        yield 'ClassNotExist' => [
            [],
            'kk'
        ];
    }
}
