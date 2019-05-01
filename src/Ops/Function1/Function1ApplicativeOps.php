<?php

namespace Collection\Ops\Function1;

use Collection\Any;
use Collection\Function1;

trait Function1ApplicativeOps
{
    use Function1FunctorOps;

    public function pure($a): self
    {
        return Function1($a);
    }

    /**
     * Function1<A,B> $this
     *
     * @param Function1<A, Function1<B,C>> $f
     *
     * @return Function1<A,C>
     */
    public function apply(callable $f): self
    {

        switch ($f) {
            case $f == None():
                return None();
            case $f instanceof Function1:
                return Function1(
                    function ($x) use ($f) {
                        return $f->invokeFunctionOnArg($this->invokeFunctionOnArg($x));
                    }
                );
            default:
                throw new \BadMethodCallException();
        }
    }

    public function map2(Any $fb, callable $f): self
    {
        return $this->apply(
            $fb->map(
                function ($b) use ($f) {
                    return function ($a) use ($f, $b) {
                        return $f($a, $b);
                    };
                }
            )
        );
    }
}