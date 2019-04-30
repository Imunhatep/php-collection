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

use Collection\Ops\FunctorOps;
use Collection\Types\Kind;

trait ImmListFunctorOps
{
    use FunctorOps;
    public function map(callable $f): Kind
    {
        return ImmList(...array_map(function($element) use ($f){
            return $f($element);
        }, $this->values));
    }

    public function imap(callable $f,callable $g): Kind
    {
        return $this->map($f);
    }
}