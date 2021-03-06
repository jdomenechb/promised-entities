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

namespace PromisedEntities\CodeGenerator\MethodBody;

class GuzzleMethodBodyGenerator implements MethodBodyGenerator
{
    public function generate(\ReflectionMethod $method, array $parametersInvocationCode): string
    {
        $code = '';
        $returnType = $method->getReturnType();

        if ($returnType === null || $returnType->getName() !== 'void') {
            $code = 'return ';
        }

        $code .= '$this->promise->wait(true)->' . $method->getName() . '(';
        $code .= implode(', ', $parametersInvocationCode);
        $code .= ");";

        return $code;
    }
}
