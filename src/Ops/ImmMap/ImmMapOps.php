<?php
declare(strict_types=1);

namespace Collection\Ops\ImmMap;

use Collection\Immutable\ImmList;
use Collection\Immutable\ImmMap;
use Collection\Tuple2;
use PhpOption\Option;

trait ImmMapOps
{
    public function offsetExists($offset): bool
    {
        return property_exists($offset, $this->values);
    }

    public function offsetGet($offset)
    {
        return Option($this->values->{$offset} ?? null);
    }

    public function offsetSet($offset, $value)
    {
        throw new \TypeError("ImmMaps are immutable");
    }

    public function offsetUnset($offset)
    {
        throw new \TypeError("ImmMaps are immutable");
    }

    public function get($offset): Option
    {
        return $this->offsetGet($offset);
    }

    public function contains($offset): bool
    {
        return $this->offsetExists($offset);
    }

    public function getOrElse($offset, $default)
    {
        return $this->get($offset)->getOrElse($default);
    }

    public function keys(): \iterable
    {
        return array_keys(get_object_vars($this->values));
    }

    public function values(): \iterable
    {
        return array_values(get_object_vars($this->values));
    }


}