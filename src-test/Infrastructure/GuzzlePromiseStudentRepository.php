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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PromisedEntities\CodeGenerator\MethodBody\GuzzleMethodBodyGenerator;
use PromisedEntities\PromisedEntityFactory;
use PromisedEntities\SrcTest\Domain\Student;
use PromisedEntities\SrcTest\Domain\StudentRepository;
use Psr\Http\Message\ResponseInterface;

class GuzzlePromiseStudentRepository implements StudentRepository
{
    /**
     * @var PromisedEntityFactory
     */
    private $promisedEntityFactory;

    /** @var Client */
    private $client;

    public function __construct(MockHandler $mockHandler)
    {
        $this->promisedEntityFactory = PromisedEntityFactory::create(new GuzzleMethodBodyGenerator());

        $handlerStack = HandlerStack::create($mockHandler);
        $this->client = new Client(['handler' => $handlerStack]);
    }

    public function byId(string $id): ?Student
    {
        $promise = $this->client->getAsync(sprintf('/student/%s', $id));
        $promise = $promise->then(
            static function (ResponseInterface $response) {
                $responseBody = json_decode($response->getBody()->getContents(), true);

                return Student::fromData($responseBody['id'], $responseBody['name'], $responseBody['age']);
            },
            static function (GuzzleException $e): void {
                throw $e;
            }
        );

        /** @var Student $toReturn */
        return $this->promisedEntityFactory->build(Student::class, $promise);
    }
}
