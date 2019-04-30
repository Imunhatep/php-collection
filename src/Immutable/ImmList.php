<?php

/*
 * This file is part of Collection, library with functional structures for PHP.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Collection\Immutable;

use Collection\Ops\Foldable;
use Collection\Ops\Monad;
use Collection\Ops\Traverse;
use Collection\Ops\ImmList\ImmListApplicativeOps;
use Collection\Ops\ImmList\ImmListEqOps;
use Collection\Ops\ImmList\ImmListFoldableOps;
use Collection\Ops\ImmList\ImmListMonadOps;
use Collection\Ops\ImmList\ImmListMonoidOps;
use Collection\Ops\ImmList\ImmListOps;
use Collection\Ops\ImmList\ImmListTraverseOps;

class ImmList implements Monad, Traverse, Foldable
{
    use ImmListOps,
        ImmListApplicativeOps,
        ImmListEqOps,
        ImmListMonadOps,
        ImmListFoldableOps,
        ImmListMonoidOps,
        ImmListTraverseOps;

    const kind = ImmList;
    private $values;

    final public function __construct(...$values)
    {
        $this->values = $values;
    }

    function toString(): string
    {
        return sprintf('List(%s)', implode(',', $this->toArray()));
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public function iterator(): \Generator
    {
        foreach ($this->toArray() as $v) {
            yield $v;
        }
    }
}