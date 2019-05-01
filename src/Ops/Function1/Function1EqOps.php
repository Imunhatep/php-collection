<?php

namespace Collection\Ops\Function1;

use Collection\Types\Function1;
use PhpOption\Option;

trait Function1EqOps
{
    public function eqv(self $rhs, Option $arg = null): bool
    {
        if ($rhs instanceof Function1) {
            return $this->__invoke($arg->getOrElse(null)) == $rhs->__invoke($arg->getOrElse(null));
        }
        return false;
    }
}