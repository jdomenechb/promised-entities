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

namespace PromisedEntities\CodeGenerator\Type;

class StringTypeGenerator implements TypeGenerator
{
    public function generate(?\ReflectionType $type, ?\ReflectionMethod $referenceMethod): string
    {
        $typeCode = '';

        if ($type) {
            $name = $type->getName();

            $typeCode = ($type->allowsNull() ? '?' : '');

            if ($name === 'self' && $referenceMethod !== null) {
                $typeCode .= '\\' . $referenceMethod->getDeclaringClass()->getName();
            } else {
                $typeCode .= (!$type->isBuiltin() && $name !== 'self' ? '\\' : '')
                . $name;
            }
        }

        return $typeCode;
    }
}
