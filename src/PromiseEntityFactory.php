<?php

declare(strict_types=1);

namespace PromisedEntities;

interface PromiseEntityFactory
{
    /**
     * @return object
     */
    public function build(string $className, $promise);
}
