<?php
namespace Collection\Ops;

interface Foldable
{
    public function foldLeft($initial); // curry -> (callable $f);
    public function foldRight($initial); // curry -> (callable $f);
    public function foldMap(callable $f);
    public function fold($initial);
}