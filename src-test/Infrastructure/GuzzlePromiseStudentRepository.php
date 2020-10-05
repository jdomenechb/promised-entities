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

namespace PromisedEntities\SrcTest\Infrastructure;

use GuzzleHttp\Promise\Promise;
use PromisedEntities\CodeGenerator\MethodBody\GuzzleMethodBodyGenerator;
use PromisedEntities\PromisedEntityFactory;
use PromisedEntities\SrcTest\Domain\Student;
use PromisedEntities\SrcTest\Domain\StudentRepository;

class GuzzlePromiseStudentRepository implements StudentRepository
{
    /**
     * @var PromisedEntityFactory
     */
    private $promisedEntityFactory;

    public function __construct()
    {
        $this->promisedEntityFactory = PromisedEntityFactory::create(new GuzzleMethodBodyGenerator());
    }

    public function byId(string $id): ?Student
    {
        $promise = new Promise(function () use (&$promise, $id): void {
            switch ($id) {
                case '1':
                    $promise->resolve(Student::fromData('1', 'John Smith', 13));
                    break;

                case '2':
                    $promise->resolve(Student::fromData('2', 'Jane Doe', 14));
                    break;
            }
        });

        /** @var Student $toReturn */
        return $this->promisedEntityFactory->build(Student::class, $promise);
    }
}
