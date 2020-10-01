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
use PromisedEntities\PromiseEntityFactory;
use PromisedEntities\SrcTest\Domain\Student;
use PromisedEntities\SrcTest\Domain\StudentRepository;

class GuzzlePromiseStudentRepository implements StudentRepository
{
    /**
     * @var PromiseEntityFactory
     */
    private $promisedEntityFactory;

    public function __construct()
    {
        $this->promisedEntityFactory = PromiseEntityFactory::create(new GuzzleMethodBodyGenerator());
    }

    public function byId(string $id): ?Student
    {
        $promise = new Promise(function () use (&$promise, $id): void {
            switch ($id) {
                case '1':
                    $promise->resolve(Student::fromData('1', 'John Smith', 13));
                    break;

                default:
                    $promise->resolve(null);
            }
        });

        /** @var Student $toReturn */
        return $this->promisedEntityFactory->build(Student::class, $promise);
    }
}
