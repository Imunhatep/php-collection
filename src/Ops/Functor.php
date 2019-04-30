<?php

namespace Collection\Ops;

/**
 * Functor<F<A>>
 */
interface Functor
{
    /**
     * (A => B) => F<B>
     */
    public function map(callable $f);

    /**
     * (A => B) => (F<A> => F<B>)
     */
    public function lift($f): callable;

    /**
     * B => F<B>
     */
    public function as($b);

    /**
     * () => F<Unit>
     */
    public function void();

    /**
     * (A => B) => F<Pair<A,B>>
     */
    public function zipWith($f);
}