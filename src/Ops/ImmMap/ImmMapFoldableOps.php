<?php

/*
 * This file is part of Collection, library with functional structures for PHP.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Collection\Ops\ImmList;

use function Collection\Functions\semigroup\combine;
use function Collection\Functions\semigroup\zero;
use Collection\Types\ImmList;
use function Collection\Functions\currying\applyPartially;
use Collection\Utils\Trampoline\Done;
use Collection\Utils\Trampoline\More;
use Collection\Utils\Trampoline\Trampoline;

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
        return $this->foldLeft(zero($this->head()), function($b, $a) use ($f) { return combine($b, $f($a)); });
    }

    public function fold($initial)
    {
        return applyPartially([$initial], func_get_args(), function(callable $f) use ($initial) {
            return (!$this->isEmpty()) ? $this->foldLeft($initial, $f) : $initial;
        });
    }
}