<?php

declare(strict_types=1);

namespace PromisedEntities\SrcTest\Doubles\Classes;

class EmptyClass
{
    public function __construct(int $argument1, ?string $argument2)
    {
        // NOTHING
    }

    public static function staticMethod(int $argument1, ?string $argument2)
    {
        // NOTHING
    }
}
