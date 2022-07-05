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
    public function testGetProperties(): void
    {
        $expected = [
            new ReflectionProperty(PublicFoo::class, 'id'),
            new ReflectionProperty(PublicFoo::class, 'name'),
            new ReflectionProperty(PublicFoo::class, 'privateFoo'),
            new ReflectionProperty(PublicFoo::class, 'withDocType'),
            new ReflectionProperty(PublicFoo::class, 'withoutType'),
        ];
        self::assertEquals($expected, ReflectionUtils::getProperties(PublicFoo::class));
    }

    public function testGetParentProperties(): void
    {
        $expected = [
            new ReflectionProperty(ChildFoo::class, 'name'),
            new ReflectionProperty(ParentFoo::class, 'id'),
        ];
        self::assertEquals($expected, ReflectionUtils::getProperties(ChildFoo::class));
    }

    public function testClassNotExist(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::getProperty('kk', 'id');
    }
}
