<?php

declare(strict_types=1);

namespace PromisedEntities\Test\Integration;

use PHPUnit\Framework\TestCase;
use PromisedEntities\SrcTest\Infrastructure\GuzzlePromiseStudentRepository;

class IntegrationTest extends TestCase
{
    public function testSimpleUse(): void
    {
        $repository = new GuzzlePromiseStudentRepository();
        $student = $repository->byId('1');

        $this->assertSame('1', $student->id());
        $this->assertSame('John Smith', $student->name());
        $this->assertSame(13, $student->age());
    }
}