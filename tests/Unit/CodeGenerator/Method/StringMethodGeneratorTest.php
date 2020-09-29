<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Unit\CodeGenerator\Method;

use PromisedEntities\CodeGenerator\Method\StringMethodGenerator;
use PHPUnit\Framework\TestCase;
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

        $this->obj = new StringMethodGenerator($typeGenerator);
    }

    public function testOkWithoutArgumentsNorReturnType(): void
    {
        $expected = <<<EXPECTED
public function method()
{
return \$this->promise->wait(true)->method();
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
return \$this->promise->wait(true)->methodWithArguments(\$argument1, \$argument2);
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
return \$this->promise->wait(true)->methodWithReturnType();
}
EXPECTED;

        $reflection = new ReflectionClass(Methods::class);
        $reflectionMethod = $reflection->getMethod('methodWithReturnType');

        $result = $this->obj->generate($reflectionMethod);

        $this->assertSame($expected, $result);
    }
}
