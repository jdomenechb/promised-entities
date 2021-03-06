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

namespace PromisedEntities\Test\Integration;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PromisedEntities\SrcTest\Infrastructure\GuzzlePromiseStudentRepository;

class GuzzleIntegrationTest extends TestCase
{
    public function testSimpleUse(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['id' => '1', 'name' => 'John Smith', 'age' => 13])),
        ]);

        $repository = new GuzzlePromiseStudentRepository($mockHandler);
        $student = $repository->byId('1');

        $this->assertSame('1', $student->id());
        $this->assertSame('John Smith', $student->name());
        $this->assertSame(13, $student->age());
        $student->isHighSchoolerOrFail();

        $student->setAge(12);
        $this->assertSame(12, $student->age());

        $this->expectException(\RuntimeException::class);
        $student->isHighSchoolerOrFail();
    }

    public function testBuildingSameClassTwice(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['id' => '1', 'name' => 'John Smith', 'age' => 13])),
            new Response(200, [], json_encode(['id' => '2', 'name' => 'Jane Doe', 'age' => 14])),
        ]);

        $repository = new GuzzlePromiseStudentRepository($mockHandler);
        $student1 = $repository->byId('1');
        $student2 = $repository->byId('2');

        $this->assertSame('1', $student1->id());
        $this->assertSame('John Smith', $student1->name());
        $this->assertSame(13, $student1->age());

        $this->assertSame('2', $student2->id());
        $this->assertSame('Jane Doe', $student2->name());
        $this->assertSame(14, $student2->age());
    }
}
