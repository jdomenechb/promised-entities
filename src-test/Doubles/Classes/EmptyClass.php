<?php

declare(strict_types=1);

/**
 * This file is part of the promised-entities package.
 *
 * (c) Jordi Domènech Bonilla
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PromisedEntities\SrcTest\Doubles\Classes;

class EmptyClass
{
    public function __construct(int $argument1, ?string $argument2)
    {
        // NOTHING
    }

    public static function staticMethod(int $argument1, ?string $argument2): void
    {
        // NOTHING
    }
}
