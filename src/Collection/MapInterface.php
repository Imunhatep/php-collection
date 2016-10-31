<?php

/*
 * Copyright 2016 Johannes M. Schmitt, Artyom Sukharev <aly.casus@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Collection;

use PhpOption\Option;

/**
 * Basic map interface.
 *
 * @author Artyom Sukharev <aly.casus@gmail.com>, J. M. Schmitt
 */
interface MapInterface extends \Traversable, \Countable
{
    /**
     * Returns the first element in the collection if available.
     *
     * @return Option on array<K,V>
     */
    public function headOption();

    /**
     * Returns the first element in the collection if available.
     *
     * @return null|array(K => V)
     */
    public function head();

    /**
     * Returns the last element in the collection if available.
     *
     * @return Option on array<K,V>
     */
    public function lastOption();

    /**
     * Returns the last element in the collection if available.
     *
     * @return null|array(K => V)
     */
    public function last();
    
    /**
     * Returns all elements in this collection.
     *
     * @return array
     */
    public function all();

    /**
     * Searches the collection for an element.
     *
     * @param callable $callable receives the element as first argument, and returns true, or false
     *
     * @return Option on array<K,V>
     */
    public function find(callable $callable);

    /**
     * Returns the value associated with the given key.
     *
     * @param mixed $key
     *
     * @return Option on V
     */
    public function get($key);

    /**
     * Returns whether this map contains a given key.
     *
     * @param mixed $key
     *
     * @return boolean
     */
    public function containsKey($key);

    /**
     * Puts a new element in the map.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function set($key, $value);

    /**
     * Removes an element from the map.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function remove($key);

    /**
     * Adds all another map to this map, and returns itself.
     *
     * @param MapInterface $map
     *
     * @return MapInterface
     */
    public function addMap(MapInterface $map);

    /**
     * Returns an array with the keys.
     *
     * @return array
     */
    public function keys();

    /**
     * Returns an array with the values.
     *
     * @return array
     */
    public function values();

    /**
     * Returns a new sequence by omitting the given number of elements from the beginning.
     *
     * If the passed number is greater than the available number of elements, all will be removed.
     *
     * @param integer $number
     *
     * @return MapInterface
     */
    public function drop($number);

    /**
     * Returns a new sequence by omitting the given number of elements from the end.
     *
     * If the passed number is greater than the available number of elements, all will be removed.
     *
     * @param integer $number
     *
     * @return MapInterface
     */
    public function dropRight($number);

    /**
     * Returns a new sequence by omitting elements from the beginning for as long as the callable returns true.
     *
     * @param callable $callable Receives the element to drop as first argument, and returns true (drop), or false (stop).
     *
     * @return MapInterface
     */
    public function dropWhile(callable $callable);

    /**
     * Creates a new collection by taking the given number of elements from the beginning
     * of the current collection.
     *
     * If the passed number is greater than the available number of elements, then all elements
     * will be returned as a new collection.
     *
     * @param integer $number
     *
     * @return MapInterface
     */
    public function take($number);

    /**
     * Creates a new collection by taking elements from the current collection
     * for as long as the callable returns true.
     *
     * @param callable $callable
     *
     * @return MapInterface
     */
    public function takeWhile(callable $callable);

    /**
     * Builds a new collection by applying a function to all elements of this map.
     *
     * @param callable $callable Callable takes function(mixed $key, mixed $value): MapInterface
     * @return MapInterface
     */
    public function map(callable $callable);

    /**
     * Creates a new collection by applying the passed callable to all elements
     * of the current collection.
     *
     * @param callable $callable Callable takes function(mixed $key, mixed $value): MapInterface
     *
     * @return MapInterface
     */
    public function flatMap(callable $callable);

    /**
     * Applies the callable to an initial value and each element, going left to right.
     *
     * @param mixed $initialValue
     * @param callable $callable receives the current value (the first time this equals $initialValue) and the element
     *
     * @return mixed the last value returned by $callable, or $initialValue if collection is empty.
     */
    public function foldLeft($initialValue, callable $callable);

    /**
     * Applies the callable to each element, and an initial value, going right to left.
     *
     * @param mixed $initialValue
     * @param callable $callable receives the element, and the current value (the first time this equals $initialValue).
     * @return mixed the last value returned by $callable, or $initialValue if collection is empty.
     */
    public function foldRight($initialValue, callable $callable);
}
