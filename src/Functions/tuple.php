<?php declare(strict_types=1);

use Collection\Tuple;
use Collection\Tuple1;
use Collection\Tuple2;
use Collection\Unit;

const Tuple = "Tuple";
const Tuple1 = "Tuple1";
const Tuple2 = "Tuple2";
const Unit = "Unit";

function Tuple(...$values): Tuple
{
    switch (count($values)) {
        case 0:
            return new Unit();
        case 2:
            return new Tuple2(...$values);
        default:
            return new Tuple1(...$values);
    }
}

function Tuple1(...$values)
{
    switch (count($values)) {
        case 1:
            return new Tuple1($values[0]);
        default:
            throw new \InvalidArgumentException('Tuple1 expects exactly 1 argument');
    }
}

function Tuple2(...$values)
{
    switch (count($values)) {
        case 2:
            return new Tuple2(...$values);
        default:
            throw new \InvalidArgumentException('Tuple2 expects exactly 2 arguments');
    }
}

