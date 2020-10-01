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

namespace PromisedEntities\Test\Unit\CodeGenerator\Classes;

use PHPUnit\Framework\TestCase;
use PromisedEntities\CodeGenerator\Classes\StringClassGenerator;
use PromisedEntities\CodeGenerator\Method\MethodGenerator;
use PromisedEntities\SrcTest\Doubles\Classes\ClassWithMethods;
use PromisedEntities\SrcTest\Doubles\Classes\EmptyClass;
use PromisedEntities\SrcTest\Doubles\Classes\EmptyInterface;
use PromisedEntities\SrcTest\Doubles\Classes\Promise;

class StringClassGeneratorTest extends TestCase
{
    /** @var StringClassGenerator */
    private $obj;

    protected function setUp(): void
    {
        $methodGenerator = $this->createMock(MethodGenerator::class);
        $methodGenerator->method('generate')->willReturn('{method}');

        $this->obj = new StringClassGenerator($methodGenerator);
    }

    public function testWithoutMethods(): void
    {
        $reflection = new \ReflectionClass(EmptyClass::class);
        $reflectionPromise = new \ReflectionClass(Promise::class);

        $result = $this->obj->generate($reflection, $reflectionPromise);

        $expectedClassCode = <<<EXPECTED
namespace PromisedEntities\SrcTest\Doubles\Classes;

class PromisedEmptyClass extends \PromisedEntities\SrcTest\Doubles\Classes\EmptyClass implements \PromisedEntities\PromisedEntity
{
    /** @var \PromisedEntities\SrcTest\Doubles\Classes\Promise */
    private \$promise;

    public function __construct(\PromisedEntities\SrcTest\Doubles\Classes\Promise \$promise)
    {
        \$this->promise = \$promise;
    }
    

}
EXPECTED;

        $this->assertSame($result->fullClassName(), 'PromisedEntities\SrcTest\Doubles\Classes\PromisedEmptyClass');
        $this->assertSame($result->classCode(), $expectedClassCode);
    }

    public function testImplementedClass(): void
    {
        $reflection = new \ReflectionClass(EmptyInterface::class);
        $reflectionPromise = new \ReflectionClass(Promise::class);

        $result = $this->obj->generate($reflection, $reflectionPromise);

        $expectedClassCode = <<<EXPECTED
namespace PromisedEntities\SrcTest\Doubles\Classes;

class PromisedEmptyInterface implements \PromisedEntities\PromisedEntity, \PromisedEntities\SrcTest\Doubles\Classes\EmptyInterface
{
    /** @var \PromisedEntities\SrcTest\Doubles\Classes\Promise */
    private \$promise;

    public function __construct(\PromisedEntities\SrcTest\Doubles\Classes\Promise \$promise)
    {
        \$this->promise = \$promise;
    }
    

}
EXPECTED;

        $this->assertSame($result->fullClassName(), 'PromisedEntities\SrcTest\Doubles\Classes\PromisedEmptyInterface');
        $this->assertSame($result->classCode(), $expectedClassCode);
    }

    public function testWithMethods(): void
    {
        $reflection = new \ReflectionClass(ClassWithMethods::class);
        $reflectionPromise = new \ReflectionClass(Promise::class);

        $result = $this->obj->generate($reflection, $reflectionPromise);

        $expectedClassCode = <<<EXPECTED
namespace PromisedEntities\SrcTest\Doubles\Classes;

class PromisedClassWithMethods extends \PromisedEntities\SrcTest\Doubles\Classes\ClassWithMethods implements \PromisedEntities\PromisedEntity
{
    /** @var \PromisedEntities\SrcTest\Doubles\Classes\Promise */
    private \$promise;

    public function __construct(\PromisedEntities\SrcTest\Doubles\Classes\Promise \$promise)
    {
        \$this->promise = \$promise;
    }
    
{method}

{method}
}
EXPECTED;

        $this->assertSame($result->fullClassName(), 'PromisedEntities\SrcTest\Doubles\Classes\PromisedClassWithMethods');
        $this->assertSame($result->classCode(), $expectedClassCode);
    }
}
