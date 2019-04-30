<?php

namespace Collection\Ops;

interface FlatMap extends Functor
{
    /**
     * (A => F<B>) => F(B)
     */
    public function flatMap(callable $f);
}