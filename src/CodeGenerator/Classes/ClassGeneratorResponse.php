<?php

declare(strict_types=1);

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
