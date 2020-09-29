<?php

declare(strict_types=1);

namespace PromisedEntities;

use GuzzleHttp\Promise\PromiseInterface;
use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;
use PromisedEntities\CodeGenerator\Type\TypeGenerator;

class GuzzlePromiseEntityFactory implements PromiseEntityFactory
{
    /**
     * @var TypeGenerator
     */
    private $typeGenerator;

    public function __construct()
    {
        $this->typeGenerator = new StringTypeGenerator();
    }

    /**
     * @param string $className
     * @param PromiseInterface $promise
     * @throws \ReflectionException
     */
    public function build(string $className, $promise)
    {
        $reflection = new \ReflectionClass($className);
        $reflectionPromise = new \ReflectionClass($promise);

        $promisedClassName = 'Promised' . $reflection->getShortName();
        $promisedClassNamespace = $reflection->getNamespaceName();
        $fullPromisedClassName = $promisedClassNamespace . '\\' . $promisedClassName;

        $relation = $reflection->isInterface()? 'implements': 'extends';

        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $methodsCode = [];

        foreach ($methods as $method) {
            if ($method->getName() === '__construct' || $method->isStatic()) {
                continue;
            }

            $parametersCode = [];
            $parametersInvocationCode = [];

            foreach ($method->getParameters() as $parameter) {
                $typeCode = $this->typeGenerator->generate($parameter->getType());

                $parametersCode[] = $typeCode . '$' . $parameter->getName();
                $parametersInvocationCode[] = '$' . $parameter->getName();
            }

            $methodCode = "public function {$method->getName()}(";
            $methodCode .= implode(', ', $parametersCode);
            $methodCode .= ")";

            if ($method->hasReturnType()) {
                $methodCode .= ': ' . $this->typeGenerator->generate($method->getReturnType());
            }

            $methodCode .= "{\n";
            $methodCode .= 'return $this->promise->wait(true)->' . $method->getName() . '(';
            $methodCode .= implode(', ', $parametersInvocationCode);
            $methodCode .= ");\n";
            $methodCode .= "}";

            $methodsCode[] = $methodCode;
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

        eval($classCode);

        return new $fullPromisedClassName($promise);
    }
}
