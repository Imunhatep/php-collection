<?php
declare(strict_types=1);

namespace Collection;

trait TupleLike
{
    abstract function swap(): Tuple;

    function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException(
                'Undefined property exception. Requested property does not exist: ' . $name
            );
        }

        return $this->{$name};
    }

    function __toString(): string
    {
        return sprintf('(%s)', implode(',', $this->toArray()));
    }

    function toString(): string
    {
        return (string) $this;
    }

    function toArray(): array
    {
        return array_values(get_object_vars($this));
    }

    function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
