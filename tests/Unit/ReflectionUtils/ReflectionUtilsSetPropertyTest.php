<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Unit\ReflectionUtils;

use Codigaco\PhpUtils\ReflectionUtils;
use Codigaco\PhpUtils\Tests\Providers\PublicFoo;
use PHPUnit\Framework\TestCase;

/** @see ReflectionUtils::setProperty() */
class ReflectionUtilsSetPropertyTest extends TestCase
{
    public function testSetPrivateProperty(): void
    {
        $foo = new PublicFoo(1, 'Pepe');
        ReflectionUtils::setProperty($foo, 'id', 2);
        self::assertEquals(2, $foo->id());
    }

    public function testSetPublicProperty(): void
    {
        $foo = new PublicFoo(1, 'Pepe');
        ReflectionUtils::setProperty($foo, 'name', 'asdf');
        self::assertEquals('asdf', $foo->name);
    }
}
