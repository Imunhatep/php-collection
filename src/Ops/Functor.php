<?php

namespace Collection\Ops;

use Collection\Any;

/**
 * Functor<F<A>>
 */
interface Functor extends Any
{
    /**
     * (A => B) => F<B>
     */
    function map(callable $f);

    /**
     * (A => B) => (F<A> => F<B>)
     */
    function lift($f): callable;

    /**
     * B => F<B>
     */
    function as($b);

    /**
     * () => F<Unit>
     */
    function void();

    /**
     * (A => B) => F<Pair<A,B>>
     */
    function zipWith(callable $f);
}