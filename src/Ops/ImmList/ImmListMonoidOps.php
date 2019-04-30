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

use function Collection\Functions\immlist\concat;
use Collection\Types\ImmList;

trait ImmListMonoidOps
{
    public function zero()
    {
        return Nil();
    }

    public function combine(ImmList $b)
    {
        return concat($this, $b);
    }
}