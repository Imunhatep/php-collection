<?php
namespace Collection\Ops;

trait FunctorOps
{
    abstract function map(callable $f);

    /**
     * (A => B) => (F<A> => F<B>)
     */
    public function lift($f): callable
    {
        return function ($fa) use ($f) {
            return $fa->map($f);
        };
    }

    /**
     * B => F<B>
     */
    public function as($b)
    {
        return $this->map(
            function ($ignored) use ($b) {
                return $b;
            }
        );
    }

    /**
     * () => F<Unit>
     */
    public function void()
    {
        return $this->map(
            function ($ignored) {
                return Unit();
            }
        );
    }

    /**
     * (A => B) => F<Tuple<A,B>>
     */
    public function zipWith($f)
    {
        return $this->map(
            function ($a) use ($f) {
                return Tuple($a, $f($a));
            }
        );
    }
}