<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Unit\CodeGenerator\Method;

use PromisedEntities\CodeGenerator\Method\StringMethodGenerator;
use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\MethodBody\MethodBodyGenerator;
use PromisedEntities\CodeGenerator\Type\TypeGenerator;
use PromisedEntities\SrcTest\Doubles\Methods;
use ReflectionClass;

class StringMethodGeneratorTest extends TestCase
{
    /** @var StringMethodGenerator */
    private $obj;

    protected function setUp(): void
    {
        $typeGenerator = $this->createMock(TypeGenerator::class);
        $typeGenerator->method('generate')->willReturn('type');

        $methodBodyGenerator = $this->createMock(MethodBodyGenerator::class);
        $methodBodyGenerator->method('generate')->willReturn('{{methodBody}}');

        $this->obj = new StringMethodGenerator($typeGenerator, $methodBodyGenerator);
    }

    public function testOkWithoutArgumentsNorReturnType(): void
    {
        $expected = <<<EXPECTED
public function method()
{
{{methodBody}}
}
EXPECTED;

        $reflection = new ReflectionClass(Methods::class);
        $reflectionMethod = $reflection->getMethod('method');

        $result = $this->obj->generate($reflectionMethod);

        $this->assertSame($expected, $result);
    }

    public function testOkWithArguments(): void
    {
        $expected = <<<EXPECTED
public function methodWithArguments(type \$argument1, type \$argument2)
{
{{methodBody}}
}
EXPECTED;

        $reflection = new ReflectionClass(Methods::class);
        $reflectionMethod = $reflection->getMethod('methodWithArguments');

        $result = $this->obj->generate($reflectionMethod);

        $this->assertSame($expected, $result);
    }

    public function testOkWithReturnType(): void
    {
        $expected = <<<EXPECTED
public function methodWithReturnType(): type
{
{{methodBody}}
}
EXPECTED;

        $reflection = new ReflectionClass(Methods::class);
        $reflectionMethod = $reflection->getMethod('methodWithReturnType');

        $result = $this->obj->generate($reflectionMethod);

        $this->assertSame($expected, $result);
    }
}
