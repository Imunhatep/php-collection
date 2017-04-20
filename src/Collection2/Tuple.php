<?php

namespace Collection2;

class Tuple
{
    use TupleLike;

    private $_1;

    function __construct($v1)
    {
        $this->_1 = $v1;
    }

    function swap(): Tuple
    {
        return clone $this;
    }
}
