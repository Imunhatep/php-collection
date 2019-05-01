<?php

/*
 * This file is part of Phunkie, library with functional structures for PHP.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Collection\Ops\Function1;

use Collection\Ops\FunctorOps;

/**
 * @mixin \Collection\Types\Function1
 */
trait Function1FunctorOps
{
    use FunctorOps;
    public function map(callable $f): self
    {
        return $this->andThen($f);
    }

    public function imap(callable $f,callable $g): self
    {
        return $this->map($f);
    }
}