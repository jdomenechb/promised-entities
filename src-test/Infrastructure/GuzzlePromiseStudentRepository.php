<?php

declare(strict_types=1);

namespace PromisedEntities\SrcTest\Infrastructure;

use GuzzleHttp\Promise\Promise;
use PromisedEntities\GuzzlePromiseEntityFactory;
use PromisedEntities\SrcTest\Domain\Student;
use PromisedEntities\SrcTest\Domain\StudentRepository;

class GuzzlePromiseStudentRepository implements StudentRepository
{
    /**
     * @var GuzzlePromiseEntityFactory
     */
    private $promisedEntityFactory;

    public function __construct()
    {
        $this->promisedEntityFactory = new GuzzlePromiseEntityFactory();
    }

    public function byId(string $id): ?Student
    {
        $promise = new Promise(function () use (&$promise, $id) {
            switch ($id) {
                case '1':
                    $promise->resolve(Student::fromData('1', 'John Smith', 13));
                    break;

                default:
                    $promise->resolve(null);
            }
        });

        /** @var Student $toReturn */
        $toReturn = $this->promisedEntityFactory->build(Student::class, $promise);

        return $toReturn;
    }
}
