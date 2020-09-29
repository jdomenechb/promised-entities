<?php

declare(strict_types=1);

namespace PromisedEntities;

use PromisedEntities\CodeGenerator\Classes\StringClassGenerator;
use PromisedEntities\CodeGenerator\Method\StringMethodGenerator;
use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;

class GuzzlePromiseEntityFactory extends AbstractPromiseEntityFactory
{
    public function __construct()
    {
        $this->classGenerator = new StringClassGenerator(new StringMethodGenerator(new StringTypeGenerator()));
    }
}
