<?php
declare(strict_types=1);

namespace Collection;

use Collection\Ops\Functor;

interface Tuple extends Functor
{
    function swap(): Tuple;

    function toString(): string;

    function toArray(): array;
}