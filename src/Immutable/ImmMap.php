<?php
declare(strict_types=1);

namespace Collection\Immutable;

use Collection\MapInterface;
use Collection\Ops\Functor;
use Collection\Ops\ImmMap\ImmMapEqOps;
use Collection\Ops\ImmMap\ImmMapFunctorOps;
use PhpOption\Option;


final class ImmMap implements \ArrayAccess, Functor, \IteratorAggregate, MapInterface
{
    use ImmMapEqOps, ImmMapFunctorOps;

    /** @var \stdClass */
    private $values;

    public function __construct(...$values)
    {
        $this->values = new \stdClass;

        switch (true) {
            case $this->noArguments($values):
                break;
            case $this->isArrayAndOneArgument($values):
                $this->createFromArray($values);
                break;
            case $this->oddNumberOfArguments($values):
                throw new \InvalidArgumentException("Not enough arguments for constructor ImmMap");
            default:
                $this->createFromVariadic($values);
        }
    }

    public function copy()
    {
        $copy = ImmMap();
        $copy->values = clone $this->values;

        return $copy;
    }

    public function plus($k, $v): ImmMap
    {
        $mappings = clone $this->values;
        $mappings[$k] = Tuple2($k, $v);

        $map = new ImmMap();
        $map->values = $mappings;

        return $map;
    }

    public function minus($k): ImmMap
    {
        $mappings = clone $this->values;
        unset($mappings[$k]);

        $map = new ImmMap();
        $map->values = $mappings;

        return $map;
    }

    public function merge(ImmMap $m): ImmMap
    {
        $mappings = clone $this->values;

        $typeFlag = false;
        foreach ($m->values as $v) {
            $typeFlag or $typeFlag = TypeOf($v, Tuple2::class);

            $mappings->{$v->_1} = $v->_2;
        }

        $map = new ImmMap();
        $map->values = $mappings;

        return $map;
    }

    public function mergeSeq(\iterable $i): ImmList
    {
        $list = array_merge((array)$this->values, $i);

        return ImmList(...$list);
    }

    function toArray(): array
    {
        return get_object_vars($this->values);
    }

    function toGenerator(): \Generator
    {
        foreach ($this->values as $v) {
            yield $v;
        }
    }

    function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->toArray());
    }

    function toIterator(): \Iterator
    {
        return $this->getIterator();
    }

    public function toString(): string
    {
        $mappings = [];
        foreach ($this->values as $k) {
            $mappings[] = $k . ' => ' . $this->values[$k]->_2;
        }

        return "Map(" . implode(", ", $mappings) . ")";
    }

    private function createFromArray(array $values)
    {
        foreach ($values[0] as $k => $v) {
            $this->values[$k] = Tuple2($k, $v);
        }
    }

    private function createFromVariadic(\iterable $values)
    {
        for ($i = 0; $i <= count($values) - 1; $i += 2) {
            $this->values[$values[$i]] = Tuple2($values[$i], $values[$i + 1]);
        }
    }

    private function isArrayAndOneArgument($values)
    {
        return count($values) == 1 && is_array($values[0]);
    }

    private function noArguments($values)
    {
        return count($values) == 0;
    }

    private function oddNumberOfArguments($values)
    {
        return count($values) % 2 != 0;
    }
}