<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Providers;

class PrivateFoo
{
    private int $id;
    private ChildFoo $childFoo;

    private function __construct()
    {
    }
}
