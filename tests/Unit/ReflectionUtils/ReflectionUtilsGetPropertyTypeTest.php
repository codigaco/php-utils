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
    public function testHasNotType(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::propertyType(PublicFoo::class, 'withoutType');
    }

    /** @dataProvider provider */
    public function testType(string $expected, string $className, string $properyName): void
    {
        self::assertEquals($expected, ReflectionUtils::propertyType($className, $properyName));
    }

    public function provider(): iterable
    {
        yield 'integer' => ['int', PublicFoo::class, 'id'];
        yield 'string' => ['string', PublicFoo::class, 'name'];
        yield 'class' => [PrivateFoo::class, PublicFoo::class, 'privateFoo'];
    }
}
