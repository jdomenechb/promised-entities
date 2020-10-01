<?php

declare(strict_types=1);

namespace PromisedEntities;

use PromisedEntities\CodeGenerator\Classes\ClassGenerator;
use PromisedEntities\CodeGenerator\Classes\StringClassGenerator;
use PromisedEntities\CodeGenerator\Method\StringMethodGenerator;
use PromisedEntities\CodeGenerator\MethodBody\MethodBodyGenerator;
use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;

final class PromiseEntityFactory
{
    /** @var ClassGenerator */
    protected $classGenerator;

    public function __construct(ClassGenerator $classGenerator)
    {
        $this->classGenerator = $classGenerator;
    }

    /**
     * @param string $className
     * @return object
     * @param mixed $promise
     * @throws \ReflectionException
     */
    public function build(string $className, $promise)
    {
        $reflection = new \ReflectionClass($className);
        $reflectionPromise = new \ReflectionClass($promise);

        $generatedClass = $this->classGenerator->generate($reflection, $reflectionPromise);
        $fullPromisedClassName = $generatedClass->fullClassName();

        eval($generatedClass->classCode());

        return new $fullPromisedClassName($promise);
    }

    public static function create(MethodBodyGenerator $methodBodyGenerator): PromiseEntityFactory
    {
        return new self(new StringClassGenerator(
            new StringMethodGenerator(
                new StringTypeGenerator(),
                $methodBodyGenerator
            )
        ));
    }
}
