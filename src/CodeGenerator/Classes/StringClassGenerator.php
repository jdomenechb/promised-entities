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

namespace PromisedEntities\CodeGenerator\Classes;

use PromisedEntities\CodeGenerator\Method\MethodGenerator;
use PromisedEntities\PromisedEntity;

class StringClassGenerator implements ClassGenerator
{
    private const CLASS_PREFIX = 'Promised';

    /** @var MethodGenerator */
    private $methodGenerator;

    public function __construct(MethodGenerator $methodGenerator)
    {
        $this->methodGenerator = $methodGenerator;
    }

    public function generate(\ReflectionClass $reflection, \ReflectionClass $reflectionPromise): ClassGeneratorResponse
    {
        $promisedClassName = self::CLASS_PREFIX . $reflection->getShortName();
        $promisedClassNamespace = $reflection->getNamespaceName();
        $fullPromisedClassName = $promisedClassNamespace . '\\' . $promisedClassName;

        $extends = [];
        $implements = [
            '\\' . PromisedEntity::class,
        ];

        if ($reflection->isInterface()) {
            $implements[] = "\\{$reflection->getName()}";
        } else {
            $extends[] = "\\{$reflection->getName()}";
        }

        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $methodsCode = [];

        foreach ($methods as $method) {
            if ($method->getName() === '__construct' || $method->isStatic()) {
                continue;
            }

            $methodsCode[] = $this->methodGenerator->generate($method);
        }

        $methodsCode = implode("\n\n", $methodsCode);

        $classCode = <<<CLASS
namespace $promisedClassNamespace;

if (!class_exists("\\$fullPromisedClassName", false)) {
class $promisedClassName
CLASS;

        if ($extends) {
            $classCode .= ' extends ' . implode(', ', $extends);
        }

        $classCode .= ' implements ' . implode(', ', $implements);

        $classCode .= "\n{
    /** @var \\{$reflectionPromise->getName()} */
    private \$promise;

    public function __construct(\\{$reflectionPromise->getName()} \$promise)
    {
        \$this->promise = \$promise;
    }
    
$methodsCode
}
}";

        return new ClassGeneratorResponse($fullPromisedClassName, $classCode);
    }
}
