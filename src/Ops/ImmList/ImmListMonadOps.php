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

use Collection\Types\ImmList;
use Collection\Types\Kind;
use Collection\Types\None;
use Collection\Types\Option;

trait ImmListMonadOps
{
    public function flatMap(callable $f): Kind
    {
        $b = [];
        foreach ($this->toArray() as $a) {
            $tmp = $f($a);
            switch (true) {
                case $f instanceof None: case $tmp instanceof None: break;
                case $tmp instanceof ImmList: foreach ($tmp->toArray() as $value) $b[] = $value; break;
                case $tmp instanceof Option: $b[] = $tmp->get(); break;
                default: throw new \BadMethodCallException("Type mismatch");
            }
        }
        return \ImmList(...$b);
    }

    public function flatten(): Kind
    {
        return $this->flatMap(function($x) { return $x; });
    }
}