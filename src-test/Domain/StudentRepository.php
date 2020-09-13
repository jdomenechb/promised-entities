<?php

declare(strict_types=1);

namespace PromisedEntities\SrcTest\Domain;

interface StudentRepository
{
    public function byId(string $id): ?Student;
}