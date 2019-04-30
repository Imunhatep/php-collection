<?php

namespace Collection\Ops\ImmSet;

use Collection\Algebra\Eq;

trait ImmSetEqOps
{
    use Eq;
    public function eqv(self $rhs): bool
    {
        return $this->toArray() == $rhs->toArray();
    }
}
