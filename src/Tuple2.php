<?php
declare(strict_types=1);

namespace Collection;

use Collection\Ops\Tuple\TupleFunctorOps;

final class Tuple2 implements Tuple
{
    use TupleFunctorOps, TupleLike;

    private $_1;
    private $_2;

    function __construct($v1, $v2)
    {
        $this->_1 = $v1;
        $this->_2 = $v2;
    }

    function swap(): Tuple
    {
        return new Tuple2($this->_2, $this->_1);
    }
}
