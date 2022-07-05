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
    public function testGetProperty(): void
    {
        $reflectionProperty = new ReflectionProperty(PublicFoo::class, 'id');
        self::assertEquals($reflectionProperty, ReflectionUtils::getProperty(PublicFoo::class, 'id'));
    }

    public function testParentProperty(): void
    {
        $reflectionProperty = new ReflectionProperty(ParentFoo::class, 'id');
        self::assertEquals($reflectionProperty, ReflectionUtils::getProperty(ChildFoo::class, 'id'));
    }

    public function testPropertyNotFound(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::getProperty(PublicFoo::class, 'kk');
    }

    public function testClassNotExist(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::getProperty('kk', 'id');
    }
}
