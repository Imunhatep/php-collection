<?php
declare(strict_types=1);

namespace Collection;

use Collection\Ops\Tuple\TupleFunctorOps;

final class Tuple1 implements Tuple
{
    use TupleFunctorOps, TupleLike;

    private $_1;

    function __construct($v1)
    {
        $this->_1 = $v1;
    }

    function swap(): Tuple1
    {
        return clone $this;
    }
}
