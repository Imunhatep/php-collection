<?php

namespace Collection\Ops\ImmList;

use Collection\Immutable\ImmList;

trait ImmListFoldableOps
{
    public function foldLeft($initial): callable
    {
        $result = $initial;

        return function (callable $f) use ($result) {
            $this->foreach(
                function ($x) use ($f, &$result) {
                    $result = $f($result, $x);
                }
            );

            return $result;
        };
    }

    public function foldRight($initial): callable
    {
        return $this
            ->reverse()
            ->foldLeft($initial);
    }

    public function foldMap(callable $f)
    {
        return $this->foldLeft(
            zero($this->head()),
            function ($b, $a) use ($f) {
                return combine($b, $f($a));
            }
        );
    }

    public function fold($initial)
    {
        return applyPartially(
            [$initial],
            func_get_args(),
            function (callable $f) use ($initial) {
                return (!$this->isEmpty()) ? $this->foldLeft($initial, $f) : $initial;
            }
        );
    }
}