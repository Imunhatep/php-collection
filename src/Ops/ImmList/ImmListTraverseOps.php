<?php


namespace Collection\Ops\ImmList;

use const Collection\Functions\option\fromSome;
use const Collection\Functions\option\isDefined;
use function Collection\Functions\show\showArrayType;
use Collection\Types\Kind;

/**
 * @mixin \Collection\Types\ImmList
 */
trait ImmListTraverseOps
{
    public function traverse(callable $f): Kind
    {
        return $this->map($f)->sequence();
    }

    public function sequence(): Kind
    {
        $typeConstructor = $this->guardIsListOfTypeConstructor();

        $sequence = $this->takeWhile(isDefined)->length == $this->length ?
            $typeConstructor($this->map(fromSome)) :
            None();

        if ($sequence instanceof Kind) {
            return $sequence;
        }

        throw new \TypeError("$typeConstructor is not a type constructor");
    }

    private function guardIsListOfTypeConstructor(): string
    {
        $listType = showArrayType($this->toArray());
        $typeConstructor = substr($listType, 0, strpos($listType, "<"));
        if ($typeConstructor == "") {
            throw new \TypeError("Cannot find a type constructor in elements of list type $listType");
        }
        if (!is_callable($typeConstructor)) {
            throw new \TypeError("$typeConstructor is not a callable type constructor");
        }
        return $typeConstructor;
    }
}