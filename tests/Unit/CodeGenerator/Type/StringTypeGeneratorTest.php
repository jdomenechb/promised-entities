<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Unit\CodeGenerator\Type;

use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;
use PHPUnit\Framework\TestCase;
use PromisedEntities\SrcTest\Doubles\Types;

class StringTypeGeneratorTest extends TestCase
{
    public function testNoType(): void
    {
        $obj = new StringTypeGenerator();
        $output = $obj->generate(null);

        $this->assertSame('', $output);
    }

    public function testSimpleType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('simpleType');

        $obj = new StringTypeGenerator();
        $output = $obj->generate($reflectionMethod->getReturnType());

        $this->assertSame('int', $output);
    }

    public function testSimpleNullableType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('simpleNullableType');

        $obj = new StringTypeGenerator();
        $output = $obj->generate($reflectionMethod->getReturnType());

        $this->assertSame('?int', $output);
    }

    public function testSelfType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('selfType');

        $obj = new StringTypeGenerator();
        $output = $obj->generate($reflectionMethod->getReturnType());

        $this->assertSame('self', $output);
    }

    public function testSelfNullableType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('selfNullableType');

        $obj = new StringTypeGenerator();
        $output = $obj->generate($reflectionMethod->getReturnType());

        $this->assertSame('?self', $output);
    }

    public function testComplexType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('complexType');

        $obj = new StringTypeGenerator();
        $output = $obj->generate($reflectionMethod->getReturnType());

        $this->assertSame('\\' . Types::class, $output);
    }

    public function testComplexNullableType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('complexNullableType');

        $obj = new StringTypeGenerator();
        $output = $obj->generate($reflectionMethod->getReturnType());

        $this->assertSame('?\\' . Types::class, $output);
    }
}
