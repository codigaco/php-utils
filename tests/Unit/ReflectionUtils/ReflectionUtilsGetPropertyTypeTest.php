<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Unit\ReflectionUtils;

use Codigaco\PhpUtils\ReflectionUtils;
use Codigaco\PhpUtils\Tests\Providers\PrivateFoo;
use Codigaco\PhpUtils\Tests\Providers\PublicFoo;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/** @see ReflectionUtils::propertyType() */
class ReflectionUtilsGetPropertyTypeTest extends TestCase
{
    public function testType(): void
    {
        self::assertEquals('int', ReflectionUtils::propertyType(PublicFoo::class, 'id'));
        self::assertEquals('string', ReflectionUtils::propertyType(PublicFoo::class, 'name'));
        self::assertEquals(PrivateFoo::class, ReflectionUtils::propertyType(PublicFoo::class, 'privateFoo'));
    }

    public function testHasNotType(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::propertyType(PublicFoo::class, 'withoutType');
    }
}
