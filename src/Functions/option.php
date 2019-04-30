<?php

namespace {

    use PhpOption\None;
    use PhpOption\Option;
    use PhpOption\Some;

    function Option($t)
    {
        return Option::fromValue($t);
    }

    function Some($t): Option
    {
        return new Some($t);
    }

    function None(): Option
    {
        return None::create();
    }
}

namespace Collection\Functions\option {

    use Collection\Immutable\ImmList;
    use PhpOption\Option;

    const isSome = "\\Collection\\Functions\\option\\isDefined";
    function isSome(Option $x): bool
    {
        return $x->isDefined();
    }

    const isNone = "\\Collection\\Functions\\option\\isNone";
    const isNothing = "\\Collection\\Functions\\option\\isNone";
    const isEmpty = "\\Collection\\Functions\\option\\isNone";
    function isNone(Option $x): bool
    {
        return $x->isEmpty();
    }

    const fromSome = "\\Collection\\Functions\\option\\fromSome";
    const fromJust = "\\Collection\\Functions\\option\\fromSome";
    function fromSome(Option $x)
    {
        if (isNone($x)) throw new \Error("Can not get a value from None.");
        return $x->get();
    }

    const listToOption = "\\Collection\\Functions\\option\\listToOption";
    function listToOption(ImmList $xs): Option
    {
        return $xs->isEmpty() ? None() : Some($xs->head);
    }

    const optionToList = "\\Collection\\Functions\\option\\optionToList";
    function optionToList(Option $x): ImmList
    {
        return $x->isEmpty() ? Nil() : ImmList($x->get());
    }
}