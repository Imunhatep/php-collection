<?php

namespace Collection\Ops\ImmSet;

use Collection\Types\ImmSet;
use Collection\Types\Kind;
use Collection\Types\None;
use Collection\Types\Option;

trait ImmSetMonadOps
{
    public function flatMap(callable $f): Kind
    {
        $b = [];
        foreach ($this->toArray() as $a) {
            $tmp = $f($a);
            switch (true) {
                case $f instanceof None: case $tmp instanceof None: break;
                case $tmp instanceof ImmSet: foreach ($tmp->toArray() as $value) $b[] = $value; break;
                case $tmp instanceof Option: $b[] = $tmp->get(); break;
                default: throw new \BadMethodCallException('Type mismatch');
            }
        }
        return \ImmSet(...$b);
    }

    public function flatten(): Kind
    {
        return $this->flatMap(function($x) { return $x; });
    }
}
