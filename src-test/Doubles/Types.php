<?php

declare(strict_types=1);

namespace PromisedEntities\SrcTest\Doubles;

interface Types
{
    public function simpleType(): int;
    public function simpleNullableType(): ?int;
    public function selfType(): self;
    public function selfNullableType(): ?self;
    public function complexType(): Types;
    public function complexNullableType(): ?Types;
}