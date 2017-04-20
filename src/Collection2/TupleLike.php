<?php

namespace Collection2;

trait TupleLike
{
    abstract function swap();

    function __get(string $name)
    {
        if(!property_exists($this, $name)){
            throw new \InvalidArgumentException('Undefined property exception. Requested property does not exist: ' . $name);
        }

        return $this->{$name};
    }

    function jsonSerialize(): array
    {
        return array_values(get_object_vars($this));
    }
}
