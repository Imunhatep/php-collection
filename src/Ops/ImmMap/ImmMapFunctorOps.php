<?php

namespace Collection\Ops\ImmMap;

use Collection\Immutable\ImmList;
use Collection\MapInterface;
use Collection\Ops\FunctorOps;
use Collection\Immutable\ImmMap;
use Collection\Tuple2;

trait ImmMapFunctorOps
{
    use FunctorOps, ImmMapMonadOps, ImmMapOps;


    public function forEach(callable $f): ImmMap
    {
        foreach ($this->values as $v) {
            $f($v);
        }
    }

    public function reverse(): ImmMap
    {
        return ImmMap(...array_reverse($this->toArray()));
    }

    public function map(callable $f): ImmMap
    {
        $mappings = new \stdClass;

        $typeFlag = false;

        foreach ($this->values as $v) {
            $value = $f($v);

            $typeFlag or $typeFlag = TypeOf($value, Tuple2::class);

            $mappings->{$value->_1} = $value->_2;
        }

        $map = new ImmMap();
        $map->values = $mappings;

        return $map;
    }



    public function void()
    {
        return $this->map(
            function (Tuple2 $keyValue) {
                return Tuple2($keyValue->_1, Unit());
            }
        );
    }

    public function zipWith(callable $f)
    {
        return $this->map(
            function (Tuple2 $keyValue) use ($f) {
                return Tuple2($keyValue->_1, Tuple2($keyValue->_2, $f($keyValue->_2)));
            }
        );
    }
}