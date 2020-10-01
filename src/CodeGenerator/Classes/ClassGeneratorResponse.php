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

/**
 * @psalm-immutable
 */
class ClassGeneratorResponse
{
    /** @var string */
    private $fullClassName;

    /** @var string */
    private $classCode;

    public function __construct(string $fullClassName, string $classCode)
    {
        $this->fullClassName = $fullClassName;
        $this->classCode = $classCode;
    }

    public function fullClassName(): string
    {
        return $this->fullClassName;
    }

    public function classCode(): string
    {
        return $this->classCode;
    }
}
