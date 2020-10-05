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

namespace PromisedEntities\SrcTest\Doubles;

interface Methods
{
    public function method();
    public function methodVoid(): void;
    public function methodWithArguments(int $argument1, $argument2);
    public function methodWithReturnType(): int;
}
