<?php

declare(strict_types=1);

namespace PromisedEntities\SrcTest\Doubles;

interface Methods
{
    public function method();
    public function methodWithArguments(int $argument1, $argument2);
    public function methodWithReturnType() :int;
}
