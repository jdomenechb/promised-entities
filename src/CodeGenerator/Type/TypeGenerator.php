<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\Type;


interface TypeGenerator
{
    public function generate(?\ReflectionType $type): string;
}