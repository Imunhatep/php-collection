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
    public function foldLeft($initial)
    {
        return applyPartially([$initial], func_get_args(), function(callable $f) use ($initial) {
            $acc = function(ImmList $xs, $initial) use (&$acc, $f): Trampoline {
                return $xs->isEmpty() ? new Done($initial) :
                    new More(function() use ($acc, $f, $xs, $initial) {
                        return $acc($xs->tail(), $f($initial, $xs->head()));
                    });
            };
            return $acc($this, $initial)->run();
        });
    }

    public function foldRight($initial)
    {
        return applyPartially([$initial], func_get_args(), function(callable $f) use ($initial) {
            $acc = function (ImmList $xs, $initial) use (&$acc, $f): Trampoline {
                return $xs->isEmpty() ? new Done($initial) :
                    new More(function() use ($acc, $f, $xs, $initial) {
                        return $acc($xs->init(), $f($xs->last(), $initial));
                    });
            };
            return $acc($this, $initial)->run();
        });
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