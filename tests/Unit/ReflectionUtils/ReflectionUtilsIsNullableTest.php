<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Unit\ReflectionUtils;

use Codigaco\PhpUtils\ReflectionUtils;
use Codigaco\PhpUtils\Tests\Providers\PublicFoo;
use PHPUnit\Framework\TestCase;

/** @see ReflectionUtils::isNullable() */
class ReflectionUtilsIsNullableTest extends TestCase
{
    /** @dataProvider provider */
    public function testPropertyIsNullable(string $className, string $propertyName, bool $exepected): void
    {
        self::assertEquals($exepected, ReflectionUtils::isNullable($className, $propertyName));
    }

    public function provider(): iterable
    {
        yield [PublicFoo::class, 'id', false];
        yield [PublicFoo::class, 'name', true];
        yield [PublicFoo::class, 'privateFoo', true];
        yield [PublicFoo::class, 'withoutType', true];
        yield [PublicFoo::class, 'privateFoo.id', false];
    }
}
