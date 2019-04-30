<?php
namespace Collection;

use PhpOption\Option;

/**
 * Basic map interface.
 *
 * @author Artyom Sukharev
 */
interface MapInterface extends \Traversable, \Countable
{
    /**
     *
     * Returns a new mutable map containing the elements from the left hand operand followed by
     * the elements from the right hand operand. The element type of the mutable map is the most
     * specific superclass encompassing the element types of the two operands.
     *
     * @param MapInterface $a
     *
     * @return MapInterface
     */
    function merge(MapInterface $a): MapInterface;

    /**
     * def aggregate[B](z: ⇒ B)(seqop: (B, (K, V)) ⇒ B, combop: (B, B) ⇒ B): B
     *
     * Aggregates the results of applying an operator to subsequent elements.
     *
     * This is a more general form of fold and reduce. It is similar to foldLeft in that it
     * doesn't require the result to be a supertype of the element type. In addition, it allows parallel
     * collections to be processed in chunks, and then combines the intermediate results.
     *
     * aggregate splits the traversable or iterator into partitions and processes each partition
     * by sequentially applying seqop, starting with z (like foldLeft). Those intermediate results are
     * then combined by using combop (like fold). The implementation of this operation may operate on an arbitrary
     * number of collection partitions (even 1), so combop may be invoked an arbitrary number of times (even 0).
     *
     * As an example, consider summing up the integer values of a list of chars. The initial value for the sum is 0.
     * First, seqop transforms each input character to an Int and adds it to the sum (of the partition).
     * Then, combop just needs to sum up the intermediate results of the partitions:
     *
     * List('a', 'b', 'c').aggregate(0)({ (sum, ch) => sum + ch.toInt }, { (p1, p2) => p1 + p2 })
     * B - the type of accumulated results
     *
     *
     * @param mixed    $z      The initial value for the accumulated result of the partition -
     *                         this will typically be the neutral element for the seqop operator
     *                         (e.g. Nil for list concatenation or 0 for summation) and may be evaluated more than once
     * @param callable $seqop  an operator used to accumulate results within a partition
     * @param callable $combop an operator used to accumulate results within a partition
     *
     * @return mixed
     */
    function aggregate($z, callable $seqop, callable $combop);

    /**
     * Retrieves the value which is associated with the given key.
     * This method invokes the default method of the map if there is no mapping from the given key to a value.
     * Unless overridden, the default method throws a NoSuchElementException.
     *
     * @param $key
     *
     * @return mixed
     */
    function apply($key);

    /**
     * Applies this partial function to the given argument when it is contained in the function domain.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    function applyOrElse($key, $default);

    /**
     * Removes all bindings from the map.
     *
     * @return MapInterface
     */
    function clear(): MapInterface;

    /**
     * Tests whether this map contains a binding for a key.
     *
     * @param $key
     *
     * @return bool
     */
    function contains($key): bool;

    function count(): Int;

    /**
     * def countBy(p: ((K, V)) ⇒ Boolean): Int
     *
     * Counts the number of elements in the traversable or iterator which satisfy a predicate.
     *
     * @param callable $p
     *
     * @return Int
     */
    function countBy(callable $p): int;

    /**
     * def drop(n: Int): HashMap[A, B]
     *
     * Selects all elements except first n ones.
     *
     * @param int $n
     *
     * @return MapInterface
     */
    function drop(int $n): MapInterface;

    /**
     * def dropRight(n: Int): HashMap[A, B]
     * Selects all elements except last n ones.
     *
     * @param int $n
     *
     * @return MapInterface
     */
    function dropRight(int $n): MapInterface;

    /**
     * def dropWhile(p: ((A, B)) ⇒ Boolean): HashMap[A, B]
     * Drops longest prefix of elements that satisfy a predicate.
     *
     * @param callable $p
     *
     * @return MapInterface
     */
    function dropWhile(callable $p): MapInterface;

    /**
     * def equals(that: Any): Boolean
     * Compares two maps structurally; i.e., checks if all mappings contained in this map are also contained in the
     * other map, and vice versa.
     *
     * @param MapInterface $that
     *
     * @return bool
     */
    function equals(MapInterface $that): bool;

    /**
     * def exists(p: ((A, B)) ⇒ Boolean): Boolean
     * Tests whether a predicate holds for at least one element of this iterable collection.
     *
     * @param callable $p
     *
     * @return bool
     */
    function exists(callable $p): bool;

    /**
     * def filter(p: ((A, B)) ⇒ Boolean): HashMap[A, B]
     * Selects all elements of this traversable collection which satisfy a predicate.
     *
     * @param callable $p
     *
     * @return MapInterface
     */
    function filter(callable $p): MapInterface;

    /**
     * def filterKeys(p: (A) ⇒ Boolean): collection.Map[A, B]
     * Filters this map by retaining only keys satisfying a predicate.
     *
     * @param callable $p
     *
     * @return MapInterface
     */
    function filterKeys(callable $p): MapInterface;

    /**
     * def find(p: ((A, B)) ⇒ Boolean): Option[(A, B)]
     * Finds the first element of the iterable collection satisfying a predicate, if any.
     *
     * @param callable $p
     *
     * @return Option
     */
    function find(callable $p): Option;

    /**
     * def flatMap[B](f: (A) ⇒ GenTraversableOnce[B]): HashMap[B]
     * [use case]
     * Builds a new collection by applying a function to all elements of this mutable hash map and using the elements
     * of the resulting collections.
     *
     * @param callable $f
     *
     * @return \iterable
     */
    function flatMap(callable $f): \iterable;

    /**
     * def flatten[B]: HashMap[B]
     * [use case]
     * Converts this mutable hash map of traversable collections into a mutable hash map formed by the elements of
     * these traversable collections.
     *
     * @return \iterable
     */
    function flatten(): \iterable;

    /**
     * def foldLeft[B](z: B)(op: (B, (A, B)) ⇒ B): B
     * Applies a binary operator to a start value and all elements of this traversable or iterator, going left to right.
     *
     * @param          $z
     * @param callable $op
     *
     * @return mixed
     */
    function foldLeft($z, callable $op);

    /**
     * def foldRight[B](z: B)(op: ((A, B), B) ⇒ B): B
     * Applies a binary operator to all elements of this iterable collection and a start value, going right to left.
     *
     * @param          $z
     * @param callable $op
     *
     * @return mixed
     */
    function foldRight($z, callable $op);

    /**
     * def forall(p: ((A, B)) ⇒ Boolean): Boolean
     * Tests whether a predicate holds for all elements of this iterable collection.
     *
     * @param callable $p
     *
     * @return MapInterface
     */
    function forall(callable $p): MapInterface;

    /**
     * def foreach(f: (A) ⇒ Unit): Unit
     * [use case] Applies a function f to all elements of this mutable hash map.
     *
     * @param callable $p
     *
     * @return mixed
     */
    function foreach (callable $p);

    /**
     * def get(key: A): Option[B]
     * Optionally returns the value associated with a key.
     *
     * @param $key
     *
     * @return Option
     */
    function get($key): Option;

    /**
     * def getOrElse(key: A, default: ⇒ B): B
     * [use case] Returns the value associated with a key, or a default value if the key is not contained in the map.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    function getOrElse($key, $default);

    /**
     * def getOrElseUpdate(key: A, defaultValue: ⇒ B): B
     * If given key is already in this map, returns associated value.
     *
     * @param $key
     * @param $defaultValue
     *
     * @return mixed
     */
    function getOrElseUpdate($key, $defaultValue);

    /**
     * def groupBy[K](f: ((A, B)) ⇒ K): immutable.Map[K, HashMap[A, B]]
     * Partitions this traversable collection into a map of traversable collections according to some discriminator
     * function.
     *
     * @param callable $f
     *
     * @return MapInterface
     */
    function groupBy(callable $f): MapInterface;

    /**
     * def grouped(size: Int): Iterator[HashMap[A, B]]
     * Partitions elements in fixed size iterable collections.
     *
     * @param int $size
     *
     * @return \iterable
     */
    function grouped(int $size): \iterable;

    /**
     * def hasDefiniteSize: Boolean
     * Tests whether this traversable collection is known to have a finite size.
     *
     * @return bool
     */
    function hasDefiniteSize(): bool;

    /**
     * def hashCode(): String
     * The hashCode method for reference types.
     *
     * @return string
     */
    function hashCode(): string;

    /**
     * def head: (A, B)
     * Selects the first element of this iterable collection.
     *
     * @return Tuple2
     */
    function head(): Tuple2;

    /**
     * def headOption: Option[(A, B)]
     * Optionally selects the first element.
     *
     * @return Option
     */
    function headOption(): Option;

    /**
     * def init: HashMap[A, B]
     * Selects all elements except the last.
     *
     * @return MapInterface
     */
    function init(): MapInterface;

    /**
     * def isDefinedAt(key: A): Boolean
     * Tests whether this map contains a binding for a key.
     *
     * @param $key
     *
     * @return bool
     */
    function isDefinedAt($key): bool;

    /**
     * def isEmpty: Boolean
     * Tests whether the map is empty.
     *
     * @return bool
     */
    function isEmpty(): bool;

    /**
     * def iterator: Iterator[(A, B)]
     * Creates a new iterator over all key/value pairs of this map
     *
     * @return \Iterator
     */
    function iterator(): \Iterator;

    /**
     * def keySet: collection.Set[A]
     * Collects all keys of this map in a set.
     *
     * @return SetInterface
     */
    function keySet(): SetInterface;

    /**
     * def keys: collection.Iterable[A]
     * Collects all keys of this map in an iterable collection.
     *
     * @return \iterable
     */
    function keys(): \iterable;

    /**
     * def keysIterator: Iterator[A]
     * Creates an iterator for all keys.
     *
     * @return \Iterator
     */
    function keysIterator(): \Iterator;

    /**
     * def last: (A, B)
     * Selects the last element.
     *
     * @return Tuple2
     */
    function last(): Tuple2;

    /**
     * def lastOption: Option[(A, B)]
     * Optionally selects the last element.
     *
     * @return Option
     */
    function lastOption(): Option;

    /**
     * def map[B](f: (A) ⇒ B): HashMap[B]
     * [use case] Builds a new collection by applying a def to all elements of this mutable hash map.
     *
     * @param callable $f
     *
     * @return MapInterface
     */
    function map(callable $f): MapInterface;

    /**
     * def mapValues[W](f: (B) ⇒ W): collection.Map[A, W]
     * Transforms this map by applying a def to every retrieved value.
     *
     * @param callable $f
     *
     * @return MapInterface
     */
    function mapValues(callable $f): MapInterface;

    /**
     * def max: A
     * [use case] Finds the largest element.
     *
     * @return mixed
     */
    function max();

    /**
     * def maxBy[B](f: (A) ⇒ B): A
     * [use case] Finds the first element which yields the largest value measured by def f.
     *
     * @param callable $f
     *
     * @return mixed
     */
    function maxBy(callable $f);

    /**
     * def min: A
     * [use case] Finds the smallest element.
     *
     * @return mixed
     */
    function min();

    /**
     * def minBy[B](f: (A) ⇒ B): A
     * [use case] Finds the first element which yields the smallest value measured by def f.
     *
     * @param callable $f
     *
     * @return mixed
     */
    function minBy(callable $f);

    /**
     * def mkString(sep: String): String
     * Displays all elements of this traversable or iterator in a string using a separator string.
     *
     * @param string $sep
     *
     * @return string
     */
    function mkString(string $sep): string;

    /**
     * def nonEmpty: Boolean
     * Tests whether the traversable or iterator is not empty.
     *
     * @return bool
     */
    function nonEmpty(): bool;

    /**
     * def partition(p: ((A, B)) ⇒ Boolean): (HashMap[A, B], HashMap[A, B])
     * Partitions this traversable collection in two traversable collections according to a predicate.
     *
     * @param callable $p
     *
     * @return Tuple2
     */
    function partition(callable $p): Tuple2;

    /**
     * def put(key: A, value: B): Option[B]
     * Adds a new key/value pair to this map and optionally returns previously bound value.
     *
     * @param $key
     * @param $value
     *
     * @return Option
     */
    function put($key, $value): Option;

    /**
     * def reduce[A1 >: (A, B)](op: (A1, A1) ⇒ A1): A1
     * Reduces the elements of this traversable or iterator using the specified associative binary operator.
     *
     * @param callable $op
     *
     * @return mixed
     */
    function reduce(callable $op);

    /**
     * def reduceLeft[B >: (A, B)](op: (B, (A, B)) ⇒ B): B
     * Applies a binary operator to all elements of this traversable or iterator, going left to right.
     *
     * @param callable $op
     *
     * @return mixed
     */
    function reduceLeft(callable $op);

    /**
     * def reduceLeftOption[B >: (A, B)](op: (B, (A, B)) ⇒ B): Option[B]
     * Optionally applies a binary operator to all elements of this traversable or iterator, going left to right.
     *
     * @param callable $op
     *
     * @return Option
     */
    function reduceLeftOption(callable $op): Option;

    /**
     * def reduceOption[A1 >: (A, B)](op: (A1, A1) ⇒ A1): Option[A1]
     * Reduces the elements of this traversable or iterator, if any, using the specified associative binary operator.
     *
     * @param callable $op
     *
     * @return Option
     */
    function reduceOption(callable $op): Option;

    /**
     * def reduceRight[B >: (A, B)](op: ((A, B), B) ⇒ B): B
     * Applies a binary operator to all elements of this iterable collection, going right to left.
     *
     * @param callable $op
     *
     * @return mixed
     */
    function reduceRight(callable $op);

    /**
     * def reduceRightOption[B >: (A, B)](op: ((A, B), B) ⇒ B): Option[B]
     * Optionally applies a binary operator to all elements of this traversable or iterator, going right to left.
     *
     * @param callable $op
     *
     * @return Option
     */
    function reduceRightOption(callable $op): Option;

    /**
     * def remove(key: A): Option[B]
     * Removes a key from this map, returning the value associated previously with that key as an option.
     *
     * @param $key
     *
     * @return Option
     */
    function remove($key): Option;

    /**
     * def remove(elem1: K, elem2: K, elems: K*): Map[K, V]
     * Creates a new map with all the key/value mappings of this map except mappings with keys equal to any of the two
     * or more specified keys.
     *
     * @param $keys array
     *
     * @return MapInterface
     */
    function removeAll(...$keys): MapInterface;

    /**
     * def retain(p: (A, B) ⇒ Boolean): HashMap.this.type
     * Retains only those mappings for which the predicate p returns true.
     *
     * @param callable $p
     *
     * @return MapInterface
     */
    function retain(callable $p): MapInterface;

    /**
     * def sameElements(that: GenIterable[A]): Boolean
     * [use case] Checks if the other iterable collection contains the same elements in the same order as this mutable
     * hash map.
     *
     * @param \iterable $that
     *
     * @return bool
     */
    function sameElements(\iterable $that): bool;

    /**
     * def scan[B >: (A, B), That](z: B)(op: (B, B) ⇒ B)(implicit cbf: CanBuildFrom[HashMap[A, B], B, That]): That
     * Computes a prefix scan of the elements of the collection.
     *
     * @param          $z
     * @param callable $op
     *
     * @return mixed
     */
    function scan($z, callable $op);

    /**
     * def scanLeft[B, That](z: B)(op: (B, (A, B)) ⇒ B)(implicit bf: CanBuildFrom[HashMap[A, B], B, That]): That
     * Produces a collection containing cumulative results of applying the operator going left to right.
     *
     * @param          $z
     * @param callable $op
     *
     * @return mixed
     */
    function scanLeft($z, callable $op);

    /**
     * def scanRight[B, That](z: B)(op: ((A, B), B) ⇒ B)(implicit bf: CanBuildFrom[HashMap[A, B], B, That]): That
     * Produces a collection containing cumulative results of applying the operator going right to left.
     *
     * @param          $z
     * @param callable $op
     *
     * @return mixed
     */
    function scanRight($z, callable $op);

    /**
     * def size: Int
     * The size of this mutable hash map.
     *
     * @return int
     */
    function size(): int;

    /**
     * def slice(from: Int, until: Int): HashMap[A, B]
     * Selects an interval of elements.
     *
     * @param int $from
     * @param int $until
     *
     * @return MapInterface
     */
    function slice(int $from, int $until): MapInterface;

    /**
     * def sliding(size: Int, step: Int): Iterator[HashMap[A, B]]
     * Groups elements in fixed size blocks by passing a "sliding window" over them (as opposed to partitioning them,
     * as is done in grouped.)
     *
     * @param int $size
     * @param int $step
     *
     * @return \iterable
     */
    function sliding(int $size, int $step = 0): \iterable;

    /**
     * def span(p: ((A, B)) ⇒ Boolean): (HashMap[A, B], HashMap[A, B])
     * Splits this traversable collection into a prefix/suffix pair according to a predicate.
     *
     * @param callable $p
     *
     * @return Tuple2
     */
    function span(callable $p): Tuple2;

    /**
     * def splitAt(n: Int): (HashMap[A, B], HashMap[A, B])
     * Splits this traversable collection into two at a given position.
     *
     * @param int $n
     *
     * @return Tuple2
     */
    function splitAt(int $n): Tuple2;

    /**
     * def sum: A
     * [use case] Sums up the elements of this collection.
     *
     * @return mixed
     */
    function sum();

    /**
     * def tail: HashMap[A, B]
     * Selects all elements except the first.
     *
     * @return MapInterface
     */
    function tail(): MapInterface;

    /**
     * def tails: Iterator[HashMap[A, B]]
     * Iterates over the tails of this traversable collection.
     *
     * @return \Iterator
     */
    function tails(): \Iterator;

    /**
     * def take(n: Int): HashMap[A, B]
     * Selects first n elements.
     *
     * @param int $n
     *
     * @return MapInterface
     */
    function take(int $n): MapInterface;

    /**
     * def takeRight(n: Int): HashMap[A, B]
     * Selects last n elements.
     *
     * @param int $n
     *
     * @return MapInterface
     */
    function takeRight(int $n): MapInterface;

    /**
     * def takeWhile(p: ((A, B)) ⇒ Boolean): HashMap[A, B]
     * Takes longest prefix of elements that satisfy a predicate.
     *
     * @param callable $p
     *
     * @return MapInterface
     */
    function takeWhile(callable $p): MapInterface;

    /**
     * def toArray: Array[A]
     * [use case] Converts this mutable hash map to an array.
     *
     * @return array
     */
    function toArray(): array;

    /**
     * def toGenerator[E >: (A, B)]: Buffer[E]
     * Uses the contents of this map to create a new mutable buffer.
     *
     * @return \Generator
     */
    function toGenerator(): \Generator;

    /**
     * def toIterator: Iterator[(A, B)]
     * Returns an Iterator over the elements in this iterable collection.
     *
     * @return \Iterator
     */
    function toIterator(): \Iterator;

    /**
     * def toSeq: collection.Seq[(A, B)]
     * Converts this mutable map to a sequence.
     *
     * @return SequenceInterface
     */
    function toSeq(): SequenceInterface;

    /**
     * def toSet[B >: (A, B)]: immutable.Set[B]
     * Converts this traversable or iterator to a set.
     *
     * @return SetInterface
     */
    function toSet(): SetInterface;

    /**
     * def toStream: immutable.Stream[(A, B)]
     * Converts this iterable collection to a stream.
     *
     * @return \streamWrapper
     */
//function toStream(): \streamWrapper;

    /**
     * def toString(): String
     * Converts this map to a string.
     *
     * @return string
     */
    function toString(): string;

    /**
     * def transform(f: (A, B) ⇒ B): HashMap.this.type
     * Applies a transformation function to all values contained in this map.
     *
     * @param callable $f
     *
     * @return MapInterface
     */
    function transform(callable $f): MapInterface;

    /**
     * def unzip[A1, A2](implicit asPair: ((A, B)) ⇒ (A1, A2)): (Iterable[A1], Iterable[A2])
     * Converts this collection of pairs into two collections of the first and second half of each pair.
     *
     * @return Tuple2
     */
    function unzip(): Tuple2;

    /**
     * def update(key: A, value: B): Unit
     * Adds a new key/value pair to this map.
     *
     * @param $key
     * @param $value
     *
     * @return MapInterface
     */
    function update($key, $value): MapInterface;

    /**
     * def updated[V1 >: B](key: A, value: V1): Map[A, V1]
     * Creates a new map consisting of all key/value pairs of the current map plus a new pair of a given key and value.
     *
     * @param $key
     * @param $value
     *
     * @return MapInterface
     */
    function updated($key, $value): MapInterface;

    /**
     * def values: collection.Iterable[B]
     * Collects all values of this map in an iterable collection.
     *
     * @return \iterable
     */
    function values(): \iterable;

    /**
     * def valuesIterator: Iterator[B]
     * Creates an iterator for all values in this map.
     *
     * @return \Iterator
     */
    function valuesIterator(): \Iterator;

    /**
     * def zip[B](that: GenIterable[B]): HashMap[(A, B)]
     * [use case] Returns a mutable hash map formed from this mutable hash map and another iterable collection by
     * combining corresponding elements in pairs.
     *
     * @param \iterable $that
     *
     * @return MapInterface
     */
    function zip(\iterable $that): MapInterface;

    /**
     * def zipAll[B](that: collection.Iterable[B], thisElem: A, thatElem: B): HashMap[(A, B)]
     * [use case] Returns a mutable hash map formed from this mutable hash map and another iterable collection by
     * combining corresponding elements in pairs.
     *
     * @param \iterable $that
     * @param              $thisElem
     * @param              $thatElem
     *
     * @return MapInterface
     */
    function zipAll(\iterable $that, $thisElem, $thatElem): MapInterface;

    /**
     * def zipWithIndex: HashMap[(A, Int)]
     * [use case] Zips this mutable hash map with its indices.
     *
     * @return MapInterface
     */
    function zipWithIndex(): MapInterface;
}
