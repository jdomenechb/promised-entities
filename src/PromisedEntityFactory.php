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

namespace PromisedEntities;

use PromisedEntities\CodeGenerator\Classes\ClassGenerator;
use PromisedEntities\CodeGenerator\Classes\StringClassGenerator;
use PromisedEntities\CodeGenerator\Method\StringMethodGenerator;
use PromisedEntities\CodeGenerator\MethodBody\MethodBodyGenerator;
use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;

final class PromisedEntityFactory
{
    /** @var ClassGenerator */
    private $classGenerator;

    public function __construct(ClassGenerator $classGenerator)
    {
        $this->classGenerator = $classGenerator;
    }

    /**
     * @psalm-param class-string $className
     * @return object
     * @param object $promise
     * @throws \ReflectionException
     */
    public function build(string $className, $promise)
    {
        $reflection = new \ReflectionClass($className);
        $reflectionPromise = new \ReflectionClass($promise);

        $generatedClass = $this->classGenerator->generate($reflection, $reflectionPromise);

        /** @var class-string<PromisedEntity> $fullPromisedClassName */
        $fullPromisedClassName = $generatedClass->fullClassName();

        eval($generatedClass->classCode());

        return new $fullPromisedClassName($promise);
    }

    public static function create(MethodBodyGenerator $methodBodyGenerator): PromisedEntityFactory
    {
        return new self(new StringClassGenerator(
            new StringMethodGenerator(
                new StringTypeGenerator(),
                $methodBodyGenerator
            )
        ));
    }
}
