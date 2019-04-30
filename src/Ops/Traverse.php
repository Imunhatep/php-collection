<?php

namespace Collection\Ops;

/**
 * Traverse<F<_>>
 */
interface Traverse
{
    /**
     * (A -> G<B>) -> G<F<B>>
     */
    public function traverse(callable $f);

    /**
     * G<F<A>>
     */
    public function sequence();
}