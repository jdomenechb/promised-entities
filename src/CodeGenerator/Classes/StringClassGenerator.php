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

        $relation = $reflection->isInterface() ? 'implements' : 'extends';

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

class $promisedClassName $relation \\{$reflection->getName()} 
{
    /** @var \\{$reflectionPromise->getName()} */
    private \$promise;

    public function __construct(\\{$reflectionPromise->getName()} \$promise)
    {
        \$this->promise = \$promise;
    }
    
$methodsCode
}
CLASS;

        return new ClassGeneratorResponse($fullPromisedClassName, $classCode);
    }
}
