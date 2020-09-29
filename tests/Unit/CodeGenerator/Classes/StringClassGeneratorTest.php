<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Unit\CodeGenerator\Classes;

use PromisedEntities\CodeGenerator\Classes\StringClassGenerator;
use PromisedEntities\CodeGenerator\Method\MethodGenerator;
use PHPUnit\Framework\TestCase;
use PromisedEntities\SrcTest\Doubles\Classes\ClassWithMethods;
use PromisedEntities\SrcTest\Doubles\Classes\EmptyClass;
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

class PromisedEmptyClass extends \PromisedEntities\SrcTest\Doubles\Classes\EmptyClass 
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

    public function testWithMethods(): void
    {
        $reflection = new \ReflectionClass(ClassWithMethods::class);
        $reflectionPromise = new \ReflectionClass(Promise::class);

        $result = $this->obj->generate($reflection, $reflectionPromise);

        $expectedClassCode = <<<EXPECTED
namespace PromisedEntities\SrcTest\Doubles\Classes;

class PromisedClassWithMethods extends \PromisedEntities\SrcTest\Doubles\Classes\ClassWithMethods 
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
