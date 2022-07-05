<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Unit\ReflectionUtils;

use Codigaco\PhpUtils\ReflectionUtils;
use Codigaco\PhpUtils\Tests\Providers\PublicFoo;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/** @see ReflectionUtils::newInstanceWithProperties() */
class ReflectionUtilsNewInstanceWithPropertiesTest extends TestCase
{
    public function testNewInstanceWithProperties(): void
    {
        $data = ['name' => 'Perico', 'id' => 1];
        $reflectionResult = ReflectionUtils::newInstanceWithProperties(PublicFoo::class, $data);
        ksort($data);
        $result = new PublicFoo(...array_values($data));
        self::assertEquals($result, $reflectionResult);
    }

    public function testClassNotExist(): void
    {
        $this->expectException(ReflectionException::class);
        ReflectionUtils::getProperty('kk', 'id');
    }
}
