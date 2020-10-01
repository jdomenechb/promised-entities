<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Unit;

use PromisedEntities\CodeGenerator\Classes\ClassGenerator;
use PromisedEntities\CodeGenerator\Classes\ClassGeneratorResponse;
use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\MethodBody\MethodBodyGenerator;
use PromisedEntities\PromiseEntityFactory;
use PromisedEntities\SrcTest\Domain\Student;
use PromisedEntities\SrcTest\Doubles\Classes\EmptyClass;
use PromisedEntities\SrcTest\Doubles\Classes\Promise;

class PromiseEntityFactoryTest extends TestCase
{
    private const GENERATED_CLASS_NAME = 'PromiseEntityFactoryTestGeneratedClass';

    /** @var PromiseEntityFactory */
    private $obj;

    public function setUp(): void
    {
        $classGenerator = $this->createMock(ClassGenerator::class);
        $classGenerator->method('generate')->willReturn(
            new ClassGeneratorResponse(
                self::GENERATED_CLASS_NAME,
                'class PromiseEntityFactoryTestGeneratedClass {}'
            )
        );

        $this->obj = new PromiseEntityFactory($classGenerator);
    }

    public function testOk(): void
    {
        $instance = $this->obj->build(Student::class, $this->createMock(Promise::class));

        $this->assertInstanceOf(self::GENERATED_CLASS_NAME, $instance);
    }

    public function testStaticCreation(): void
    {
        $methodBodyGenerator = $this->createMock(MethodBodyGenerator::class);
        $obj = PromiseEntityFactory::create($methodBodyGenerator);

        $instance = $obj->build(EmptyClass::class, $this->createMock(Promise::class));
        $this->assertIsObject($instance);
    }
}
