<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\MethodBody;

interface MethodBodyGenerator
{
    public function generate(\ReflectionMethod $method, array $parametersInvocationCode): string;
}
