<?php
declare(strict_types=1);

namespace Collection;

use Collection\Ops\Tuple\TupleFunctorOps;

final class Unit implements Tuple
{
    use TupleFunctorOps, TupleLike;

    function swap(): Unit
    {
        return new Unit();
    }

    function toString(): string
    {
        return '()';
    }
}
