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

namespace PromisedEntities\Test\Unit\CodeGenerator\MethodBody;

use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\MethodBody\GuzzleMethodBodyGenerator;
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
