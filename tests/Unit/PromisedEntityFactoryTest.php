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

namespace PromisedEntities\Test\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\Classes\ClassGenerator;
use PromisedEntities\CodeGenerator\Classes\ClassGeneratorResponse;
use PromisedEntities\CodeGenerator\MethodBody\MethodBodyGenerator;
use PromisedEntities\PromisedEntityFactory;
use PromisedEntities\SrcTest\Domain\Student;
use PromisedEntities\SrcTest\Doubles\Classes\EmptyClass;
use PromisedEntities\SrcTest\Doubles\Classes\Promise;

class PromisedEntityFactoryTest extends TestCase
{
    private const GENERATED_CLASS_NAME = 'PromiseEntityFactoryTestGeneratedClass';

    /** @var PromisedEntityFactory */
    private $obj;

    /** @var MockObject|ClassGenerator */
    private $classGenerator;

    protected function setUp(): void
    {
        $this->classGenerator = $this->createMock(ClassGenerator::class);
        $this->classGenerator->method('generate')->willReturn(
            new ClassGeneratorResponse(
                self::GENERATED_CLASS_NAME,
                'if (!class_exists("\\PromiseEntityFactoryTestGeneratedClass", false)) { class PromiseEntityFactoryTestGeneratedClass {}}'
            )
        );

        $this->obj = new PromisedEntityFactory($this->classGenerator);
    }

    public function testOk(): void
    {
        $instance = $this->obj->build(Student::class, $this->createMock(Promise::class));

        $this->assertInstanceOf(self::GENERATED_CLASS_NAME, $instance);
    }

    public function testUseOfInstanceCache(): void
    {
        $this->classGenerator
            ->expects($this->once())
            ->method('generate')
            ->willReturn(
                new ClassGeneratorResponse(
                    self::GENERATED_CLASS_NAME,
                    'if (!class_exists("\\PromiseEntityFactoryTestGeneratedClass", false)) { class PromiseEntityFactoryTestGeneratedClass {}}'
                )
            );

        $instance1 = $this->obj->build(Student::class, $this->createMock(Promise::class));
        $instance2 = $this->obj->build(Student::class, $this->createMock(Promise::class));

        $this->assertInstanceOf(self::GENERATED_CLASS_NAME, $instance1);
        $this->assertInstanceOf(self::GENERATED_CLASS_NAME, $instance2);
    }

    public function testStaticCreation(): void
    {
        $methodBodyGenerator = $this->createMock(MethodBodyGenerator::class);
        $obj = PromisedEntityFactory::create($methodBodyGenerator);

        $instance = $obj->build(EmptyClass::class, $this->createMock(Promise::class));
        $this->assertIsObject($instance);
    }
}
