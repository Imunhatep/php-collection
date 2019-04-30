<?php

/*
 * This file is part of Phunkie, library with functional structures for PHP.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined('TYPE_SEQ_FIRST') or define('TYPE_SEQ_FIRST', true);

array_map(
    function ($file) {
        require_once $file;
    },
    glob(__DIR__ . '/*')
);

function TypeOf($v, $c)
{
    if (!is_a($v, $c)) {
        throw new \UnexpectedValueException(sprintf('Type of <%s> is expected, instead <%s> is received', $c, gettype($c)));
    }

    return TYPE_SEQ_FIRST;
}

const Option = 'Option';
const ImmList = 'ImmList';
const ImmSet = 'ImmSet';
const Function1 = 'Function1';
const TypeOf = 'TypeOf';

const _ = "Phunkie@Reserverd@Constant@_";
const None = 'Phunkie@Reserverd@Constant@None';
const Nil = 'Phunkie@Reserverd@Constant@Nil';