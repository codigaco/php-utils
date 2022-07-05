<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Unit\ReflectionUtils;

use Codigaco\PhpUtils\ReflectionUtils;
use Codigaco\PhpUtils\Tests\Providers\ChildFoo;
use Codigaco\PhpUtils\Tests\Providers\PrivateFoo;
use Codigaco\PhpUtils\Tests\Providers\PublicFoo;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/** @see ReflectionUtils::newInstanceWithConstructor() */
class ReflectionUtilsNewInstanceWithConstructorTest extends TestCase
{
    public function testNewInstanceWithConstructor(): void
    {
        $data = ['name' => 'Perico', 'id' => 1];
        $reflectionResult = ReflectionUtils::newInstanceWithConstructor(PublicFoo::class, $data);
        ksort($data);
        $result = new PublicFoo(...array_values($data));
        self::assertEquals($result, $reflectionResult);
    }

    public function testNewInstanceWithEmptyConstructor(): void
    {
        $reflectionResult = ReflectionUtils::newInstanceWithConstructor(ChildFoo::class, []);
        $result = new ChildFoo();
        self::assertEquals($result, $reflectionResult);
    }

    public function testPrivateConstructor(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::newInstanceWithConstructor(PrivateFoo::class, []);
    }

    public function testClassNotExist(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::getProperty('kk', 'id');
    }
}
