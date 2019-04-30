<?php

namespace Collection\Ops\Tuple;

use Collection\Ops\FunctorOps;
use Collection\Tuple;

trait TupleFunctorOps
{
    use FunctorOps;

    abstract public function toArray(): array;

    public function map(callable $f): Tuple
    {
        return Tuple(...array_map($f, $this->toArray()));
    }
}