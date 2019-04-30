<?php
declare(strict_types=1);

namespace Collection\Ops\ImmMap;


use Collection\Immutable\ImmMap;
use PhpOption\None;
use PhpOption\Option;

trait ImmMapMonadOps
{
    public function flatMap(callable $f): \iterable
    {
        $preserveType = true;

        $b = [];
        foreach ($this as $a) {
            $tmp = $f($a);
            switch (true) {

                case $tmp instanceof None:
                    break;
                case $f instanceof ImmMap:
                    foreach ($tmp as $value) {
                        $b[] = $value;
                    }

                    break;
                case $f instanceof \iterable:
                    $preserveType = false;
                    foreach ($tmp as $value) {
                        $b[] = $value;
                    }
                    break;
                case $tmp instanceof Option:
                    $preserveType = false;
                    $b[] = $tmp->get();
                    break;
                default: throw new \UnexpectedValueException("Type mismatch");
            }
        }

        return $preserveType
            ? ImmMap(...$b)
            : ImmList(...$b);
    }

    public function flatten(): ImmMap
    {
        return $this->flatMap(function($x) { return $x; });
    }
}