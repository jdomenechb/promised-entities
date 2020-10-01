<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Unit\CodeGenerator\MethodBody;

use PromisedEntities\CodeGenerator\Classes\StringClassGenerator;
use PromisedEntities\CodeGenerator\Method\MethodGenerator;
use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\MethodBody\GuzzleMethodBodyGenerator;
use PromisedEntities\SrcTest\Doubles\Classes\ClassWithMethods;
use PromisedEntities\SrcTest\Doubles\Classes\EmptyClass;
use PromisedEntities\SrcTest\Doubles\Classes\Promise;
use PromisedEntities\SrcTest\Doubles\Methods;

class GuzzleMethodBodyGeneratorTest extends TestCase
{
    /** @var GuzzleMethodBodyGenerator */
    private $obj;

    protected function setUp(): void
    {
        $this->obj = new GuzzleMethodBodyGenerator();
    }

    public function testOkWithParameters(): void
    {
        $reflection = new \ReflectionClass(Methods::class);
        $reflectionMethod = $reflection->getMethod('methodWithArguments');

        $expected = 'return $this->promise->wait(true)->methodWithArguments(argument1, argument2);';
        $parametersInvocationCode = [
            'argument1',
            'argument2'
        ];

        $result = $this->obj->generate($reflectionMethod, $parametersInvocationCode);

        $this->assertSame($expected, $result);
    }

    public function testOkWithoutParameters(): void
    {
        $reflection = new \ReflectionClass(Methods::class);
        $reflectionMethod = $reflection->getMethod('methodWithArguments');

        $expected = 'return $this->promise->wait(true)->methodWithArguments();';
        $parametersInvocationCode = [];

        $result = $this->obj->generate($reflectionMethod, $parametersInvocationCode);

        $this->assertSame($expected, $result);
    }
}
