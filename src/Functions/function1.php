<?php

namespace {
    use Collection\Function1;

    function Function1($f)
    {
        return new Function1($f);
    }

    function applyPartially($declaredArgs, $passedArgs, $f)
    {
        $countOfPassedArgs = count($passedArgs);
        $countOfDeclaredArgs = count($declaredArgs);

        if ($countOfDeclaredArgs == $countOfPassedArgs) {
            return function ($x) use ($f) {
                return $x === _ ? $f : $f($x);
            };
        }

        if ($countOfDeclaredArgs == $countOfPassedArgs - 1) {
            return $f($passedArgs[$countOfPassedArgs - 1]);
        }

        throw new \BadFunctionCallException(
            "Wrong number of arguments in curried function: " .
            "expected: $countOfDeclaredArgs or " . ($countOfDeclaredArgs + 1) .
            " found: " . $countOfPassedArgs
        );
    }

    function curry($f)
    {
        return function($a) use ($f) {
            return function ($b) use ($a, $f) {
                return $f($a, $b);
            };
        };
    }

    function uncurry($f)
    {
        return function($a, $b) use ($f) {
            return ($f($a))($b);
        };
    }

}