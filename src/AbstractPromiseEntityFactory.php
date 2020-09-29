<?php

declare(strict_types=1);

namespace PromisedEntities;

use PromisedEntities\CodeGenerator\Classes\ClassGenerator;

abstract class AbstractPromiseEntityFactory implements PromiseEntityFactory
{
    /** @var ClassGenerator */
    protected $classGenerator;

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
}
