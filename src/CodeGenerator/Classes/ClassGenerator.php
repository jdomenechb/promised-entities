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

namespace PromisedEntities\CodeGenerator\Classes;

interface ClassGenerator
{
    public function generate(\ReflectionClass $reflection, \ReflectionClass $reflectionPromise): ClassGeneratorResponse;
}
