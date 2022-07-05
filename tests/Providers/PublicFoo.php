<?php

declare(strict_types=1);

namespace Codigaco\PhpUtils\Tests\Providers;

class PublicFoo
{
    private int $id;
    public ?string $name;
    public ?PrivateFoo $privateFoo;
    /** @var bool */
    private $withDocType;
    public $withoutType;

    public function __construct(
        ?int $id,
        ?string $name = null
    ) {
        $this->id = $id ?? 0;
        $this->name = $name;
        $this->privateFoo = null;
    }

    public function id(): int
    {
        return $this->id;
    }
}
