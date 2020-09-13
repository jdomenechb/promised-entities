<?php

declare(strict_types=1);

namespace PromisedEntities\CodeGenerator\Type;

class StringTypeGenerator implements TypeGenerator
{
    public function generate(?\ReflectionType $type): string
    {
        $typeCode = '';

        if ($type) {
            $name = $type->getName();

            $typeCode = ($type->allowsNull()? '?': '')
                . (!$type->isBuiltin() && $name !== 'self'? '\\': '')
                . $name;
        }

        return $typeCode;
    }
}
