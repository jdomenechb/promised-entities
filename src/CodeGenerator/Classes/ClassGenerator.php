<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\Classes;

interface ClassGenerator
{
    public function generate(\ReflectionClass $reflection, \ReflectionClass $reflectionPromise): ClassGeneratorResponse;
}
