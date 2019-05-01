<?php

/*
 * This file is part of Collection, library with functional structures for PHP.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Collection\Immutable;

use Collection\Ops\Applicative;
use Collection\Ops\Monad;
use Collection\Ops\Show;
use function Collection\Functions\show\showArrayType;
use function Collection\Functions\show\showValue;
use function Collection\Functions\type\promote;
use Collection\Ops\ImmSet\ImmSetApplicativeOps;
use Collection\Ops\ImmSet\ImmSetEqOps;
use Collection\Ops\ImmSet\ImmSetFunctorOps;
use Collection\Ops\ImmSet\ImmSetMonadOps;
use Collection\Utils\Iterator;

class ImmSet implements Kind, Applicative, Monad
{
    use Show, ImmSetFunctorOps, ImmSetApplicativeOps, ImmSetEqOps, ImmSetMonadOps;
    private $elements = [];

    public function __construct(...$elements)
    {
        foreach ($elements as $element) {
            if (!$this->contains($element)) {
                $this->elements[] = $element;
            }
        }
    }

    public function contains($element)
    {
        return ((!is_object($element) && in_array($element, $this->elements, true)) ||
            (is_object($element) && in_array($element, $this->elements)));
    }

    public function minus($element)
    {
        if (!$this->contains($element)) {
            return ImmSet(...$this->elements);
        }

        $elements = [];
        foreach ($this->elements as $el) {
            if ((is_object($el) && $element == $el) || (!is_object($el) && $element === $el)) continue;
            $elements[] = $el;
        }
        return ImmSet(...$elements);
    }

    public function plus($element)
    {
        if ($this->contains($element)) {
            return ImmSet(...$this->elements);
        }

        return ImmSet(...array_merge($this->elements, [$element]));
    }

    public function toArray()
    {
        return $this->elements;
    }

    public function toString(): string
    {
        return "Set(" . implode(", ", array_map(function($e) { return showValue($e); }, $this->elements)) . ")";
    }

    public function getTypeArity(): int
    {
        return 1;
    }

    public function getTypeVariables(): array
    {
        return [showArrayType($this->elements)];
    }

    public function iterator()
    {
        $storage = new \SplObjectStorage();
        foreach ($this->toArray() as $k => $v) {
            $storage[promote($k)] = $v;
        }
        return new Iterator($storage);
    }

    public function union(ImmSet $set)
    {
        return ImmSet(...array_merge($this->elements, $set->elements));
    }

    public function intersect(ImmSet $set)
    {
        $new = [];
        foreach ($this->elements as $element) {
            if ($set->contains($element)) {
                $new[] = $element;
            }
        }
        return ImmSet(...$new);
    }

    public function diff(ImmSet $set)
    {
        $new = [];
        foreach ($this->elements as $element) {
            if (!$set->contains($element)) {
                $new[] = $element;
            }
        }
        foreach ($set->elements as $element) {
            if (!$this->contains($element)) {
                $new[] = $element;
            }
        }
        return ImmSet(...$new);
    }

    public function isEmpty(): bool
    {
        return [] === $this->elements;
    }
}