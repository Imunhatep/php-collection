<?php
namespace Collection\Ops;

use Collection\Any;

interface Foldable extends Any
{
    public function foldLeft($initial); // curry -> (callable $f);
    public function foldRight($initial); // curry -> (callable $f);
    public function foldMap(callable $f);
    public function fold($initial);
}