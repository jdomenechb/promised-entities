<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\Method;

interface MethodGenerator
{
    public function generate(\ReflectionMethod $method): string;
}
