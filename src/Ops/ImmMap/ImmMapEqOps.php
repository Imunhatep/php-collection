<?php
declare(strict_types=1);

namespace Collection\Ops\ImmMap;

trait ImmMapEqOps
{
    public function eqv(self $rhs): bool
    {
        $diff = ImmMap();
        foreach($rhs->iterator() as $k => $v) {
            if(!($this->contains($k) && $this[$k] == Option($v))) {
                $diff = $diff->plus($k, $v);
            }
        }

        return $diff->iterator()->count() === 0;
    }
}