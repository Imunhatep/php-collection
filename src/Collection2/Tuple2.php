<?php

namespace Collection2;

class Tuple2
{
    use TupleLike;

    private $_1;
    private $_2;

    function __construct($v1, $v2)
    {
        $this->_1 = $v1;
        $this->_2 = $v2;
    }

    function swap(): Tuple2
    {
        return new Tuple2($this->_2, $this->_1);
    }
}
