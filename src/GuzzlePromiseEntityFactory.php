<?php

declare(strict_types=1);

namespace PromisedEntities;

use GuzzleHttp\Promise\PromiseInterface;
use PromisedEntities\CodeGenerator\Method\StringMethodGenerator;
use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;

class GuzzlePromiseEntityFactory implements PromiseEntityFactory
{
    /** @var StringMethodGenerator */
    private $methodGenerator;

    public function __construct()
    {
        $this->methodGenerator = new StringMethodGenerator(new StringTypeGenerator());
    }

    /**
     * @param string $className
     * @return object
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

        eval($classCode);

        return new $fullPromisedClassName($promise);
    }
}
