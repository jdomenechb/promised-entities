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
