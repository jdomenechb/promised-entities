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

namespace PromisedEntities\Test\Unit\CodeGenerator\Type;

use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\Type\StringTypeGenerator;
use PromisedEntities\SrcTest\Doubles\Types;

class StringTypeGeneratorTest extends TestCase
{
    /** @var StringTypeGenerator */
    private $obj;

    protected function setUp(): void
    {
        $this->obj = new StringTypeGenerator();
    }

    public function testNoType(): void
    {
        $output = $this->obj->generate(null, null);

        $this->assertSame('', $output);
    }

    public function testSimpleType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('simpleType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), null);

        $this->assertSame('int', $output);
    }

    public function testSimpleNullableType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('simpleNullableType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), null);

        $this->assertSame('?int', $output);
    }

    public function testSelfType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('selfType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), null);

        $this->assertSame('self', $output);
    }

    public function testSelfNullableType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('selfNullableType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), null);

        $this->assertSame('?self', $output);
    }

    public function testComplexType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('complexType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), null);

        $this->assertSame('\\' . Types::class, $output);
    }

    public function testComplexNullableType(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('complexNullableType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), null);

        $this->assertSame('?\\' . Types::class, $output);
    }

    public function testReplacingSelfByReferenceClass(): void
    {
        $reflection = new \ReflectionClass(Types::class);
        $reflectionMethod = $reflection->getMethod('selfType');

        $output = $this->obj->generate($reflectionMethod->getReturnType(), $reflectionMethod);

        $this->assertSame('\\' . Types::class, $output);
    }
}
