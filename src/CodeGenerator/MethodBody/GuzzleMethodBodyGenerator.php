<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\MethodBody;

class GuzzleMethodBodyGenerator implements MethodBodyGenerator
{
    public function generate(\ReflectionMethod $method, array $parametersInvocationCode): string
    {
        $code = 'return $this->promise->wait(true)->' . $method->getName() . '(';
        $code .= implode(', ', $parametersInvocationCode);
        $code .= ");";

        return $code;
    }
}
