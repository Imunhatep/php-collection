<?php

/*
 * This file is part of Collection, library with functional structures for PHP.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Collection\Ops\Function1;

use Collection\Ops\FunctorOps;
use Collection\Types\Kind;

/**
 * @mixin \Collection\Types\Function1
 */
trait Function1FunctorOps
{
    use FunctorOps;
    public function map(callable $f): Kind
    {
        return $this->andThen($f);
    }

    public function imap(callable $f,callable $g): Kind
    {
        return $this->map($f);
    }
}