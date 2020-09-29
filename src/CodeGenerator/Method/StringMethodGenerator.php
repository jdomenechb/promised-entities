<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\Method;

use PromisedEntities\CodeGenerator\MethodBody\MethodBodyGenerator;
use PromisedEntities\CodeGenerator\Type\TypeGenerator;

class StringMethodGenerator implements MethodGenerator
{
    /** @var TypeGenerator */
    private $typeGenerator;

    /** @var MethodBodyGenerator */
    private $methodBodyGenerator;

    public function __construct(TypeGenerator $typeGenerator, MethodBodyGenerator $methodBodyGenerator)
    {
        $this->typeGenerator = $typeGenerator;
        $this->methodBodyGenerator = $methodBodyGenerator;
    }

    public function generate(\ReflectionMethod $method): string
    {
        $parametersCode = [];
        $parametersInvocationCode = [];

        foreach ($method->getParameters() as $parameter) {
            $typeCode = $this->typeGenerator->generate($parameter->getType());
            $typeCode = $typeCode? $typeCode .  ' ': '';

            $parametersCode[] = $typeCode . '$' . $parameter->getName();
            $parametersInvocationCode[] = '$' . $parameter->getName();
        }

        $methodCode = "public function {$method->getName()}(";
        $methodCode .= implode(', ', $parametersCode);
        $methodCode .= ")";

        if ($method->hasReturnType()) {
            $methodCode .= ': ' . $this->typeGenerator->generate($method->getReturnType());
        }

        $methodCode .= "\n{\n";
        $methodCode .= $this->methodBodyGenerator->generate($method, $parametersInvocationCode);
        $methodCode .= "\n";
        $methodCode .= "}";

        return $methodCode;
    }

}
