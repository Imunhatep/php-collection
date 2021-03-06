<?php
namespace Collection;

use PhpOption\LazyOption;
use PhpOption\None;
use PhpOption\Some;

/**
 * A sequence with numerically indexed elements.
 *
 * This is rawly equivalent to an array with only numeric keys.
 * There are no restrictions on how many same values may occur in the sequence.
 *
 * This sequence is mutable.
 *
 * @author Artyom Sukharev , J. M. Schmitt
 */
abstract class AbstractSequence implements \IteratorAggregate
{
    protected $elements;
    protected $length;

    /**
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = [];
        $this->length = 0;

        $this->addAll($elements);
    }

    /**
     * @param SequenceInterface $seq
     *
     * @return $this|SequenceInterface
     */
    public function addSequence(SequenceInterface $seq)
    {
        $this->addAll($seq);

        return $this;
    }

    /**
     * @param mixed $searchedElement
     *
     * @return int
     */
    public function indexOf($searchedElement)
    {
        foreach ($this->elements as $i => $element) {
            if ($searchedElement === $element) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * @param mixed $searchedElement
     *
     * @return int
     */
    public function lastIndexOf($searchedElement)
    {
        for ($i = $this->length - 1; $i >= 0; $i--) {
            if ($this->elements[$i] === $searchedElement) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * @return mixed|null
     */
    public function head()
    {
        if (empty($this->elements)) {
            return null;
        }

        return reset($this->elements);
    }

    /**
     * @return \PhpOption\Option
     */
    public function headOption()
    {
        if (empty($this->elements)) {
            return None::create();
        }

        return new Some(reset($this->elements));
    }

    /**
     * @return $this|SequenceInterface
     */
    public function tail()
    {
        return $this->createNew(array_slice($this->elements, 1));
    }

    /**
     * @return $this|SequenceInterface
     */
    public function reverse()
    {
        return $this->createNew(array_reverse($this->elements));
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    public function isDefinedAt($index)
    {
        return isset($this->elements[$index]);
    }

    /**
     * Returns a filtered sequence.
     *
     * @param callable $callable receives the element and must return true (= keep) or false (= remove).
     *
     * @return $this|SequenceInterface
     */
    public function filter(callable $callable)
    {
        return $this->filterInternal($callable, true);
    }

    /**
     * @param $searchedElem
     *
     * @return bool
     */
    public function contains($searchedElem)
    {
        foreach ($this as $elem) {
            if ($elem === $searchedElem) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param callable $callable
     *
     * @return LazyOption
     */
    public function find(callable $callable)
    {
        $self = $this;

        return new LazyOption(
            function () use ($callable, $self) {
                foreach ($self as $elem) {
                    if (call_user_func($callable, $elem) === true) {
                        return new Some($elem);
                    }
                }

                return None::create();
            }
        );
    }

    /**
     * Builds a new collection by applying a function to all elements of this map.
     *
     * @param callable $callable receives the element, and the current value (the first time this equals $initialValue).
     * @return $this|SequenceInterface
     */
    public function map(callable $callable)
    {
        $newElements = [];
        foreach ($this->elements as $i => $element) {
            $newElements[$i] = $callable($element);
        }

        return $this->createNew($newElements);
    }

    /**
     * Creates a new collection by applying the passed callable to all elements
     * of the current collection.
     *
     * @param callable $callable Callable takes (x : \Traversable) => \Traversable
     *
     * @return $this|SequenceInterface
     */
    public function flatMap(callable $callable)
    {
        return $this->map($callable)->flatten();
    }

    /**
     * Returns a collection when any first level nesting is flattened into the single
     * returned collection
     *
     * @return $this|SequenceInterface
     */
    public function flatten()
    {
        $res = $this->createNew([]);

        foreach ($this->elements as $elem) {
            $res->addAll($elem);
        }

        return $res;
    }

    /**
     * Returns a filtered sequence.
     *
     * @param callable $callable receives the element and must return true (= remove) or false (= keep).
     *
     * @return $this|SequenceInterface
     */
    public function filterNot(callable $callable)
    {
        return $this->filterInternal($callable, false);
    }

    private function filterInternal(callable $callable, $booleanKeep)
    {
        $newElements = [];
        foreach ($this->elements as $element) {
            if ($booleanKeep !== $callable($element)) {
                continue;
            }

            $newElements[] = $element;
        }

        return $this->createNew($newElements);
    }

    /**
     * Applies a binary operator to a start value and all elements of this set, going left to right.
     * foldLeft[B](z: B, op: (B, A) ⇒ B): B
     *
     * B - the result type of the binary operator.
     * z - the start value.
     * op -the binary operator.
     *
     * @param mixed $initialValue - the start value
     * @param callable $callable - the binary operator
     * @return mixed - the result of inserting op between consecutive elements of this set, going left to right with the start value z on the left:
     */
    public function foldLeft($initialValue, callable $callable)
    {
        $value = $initialValue;
        foreach ($this->elements as $elem) {
            $value = $callable($value, $elem);
        }

        return $value;
    }

    public function foldRight($initialValue, callable $callable)
    {
        $value = $initialValue;
        foreach (array_reverse($this->elements) as $elem) {
            $value = $callable($elem, $value);
        }

        return $value;
    }

    /**
     * Finds the first index where the given callable returns true.
     *
     * @param callable $callable
     *
     * @return integer the index, or -1 if the predicate is not true for any element.
     */
    public function indexWhere(callable $callable)
    {
        foreach ($this->elements as $i => $element) {
            if ($callable($element) === true) {
                return $i;
            }
        }

        return -1;
    }

    public function lastIndexWhere(callable $callable)
    {
        for ($i = $this->length - 1; $i >= 0; $i--) {
            if ($callable($this->elements[$i]) === true) {
                return $i;
            }
        }

        return -1;
    }

    public function last()
    {
        if (empty($this->elements)) {
            return null;
        }

        return end($this->elements);
    }

    public function lastOption()
    {
        if (empty($this->elements)) {
            return None::create();
        }

        return new Some(end($this->elements));
    }

    /**
     * @return array
     */
    public function indices()
    {
        return array_keys($this->elements);
    }

    /**
     * Returns an element based on its index (0-based).
     *
     * @param integer $index
     *
     * @return T
     */
    public function get($index)
    {
        if (!isset($this->elements[$index])) {
            throw new \OutOfBoundsException(sprintf('The index "%s" does not exist in this sequence.', $index));
        }

        return $this->elements[$index];
    }

    /**
     * Removes the element at the given index, and returns it.
     *
     * @param int $index
     *
     * @return T
     *
     * @throws \OutOfBoundsException If there is no element at the given index.
     */
    public function remove($index)
    {
        if (!isset($this->elements[$index])) {
            throw new \OutOfBoundsException(sprintf('The index "%d" is not in the interval [0, %d).', $index, $this->length));
        }

        $element = $this->elements[$index];

        unset($this->elements[$index]);
        $this->length--;

        $this->elements = array_values($this->elements);

        return $element;
    }

    /**
     * Updates the element at the given index (0-based).
     *
     * @param integer $index
     * @param T       $value
     * @return $this|SequenceInterface
     */
    public function update($index, $value)
    {
        if (!isset($this->elements[$index])) {
            throw new \InvalidArgumentException(sprintf('There is no element at index "%d".', $index));
        }

        $this->elements[$index] = $value;
        
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->elements);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->elements;
    }

    /**
     * @param mixed $newElement
     * @return $this|SequenceInterface
     */
    public function add($newElement)
    {
        $this->elements[] = $newElement;
        $this->length++;

        return $this;
    }

    /**
     * @param array|\Traversable $elements
     * @return $this|SequenceInterface
     */
    public function addAll($elements)
    {
        // check for array|Traversable
        if(!is_array($elements) && !($elements instanceof \Traversable)){
            throw new \InvalidArgumentException('Sequence::addAll() expects array or instance of \Traversable as argument');
        }

        foreach ($elements as $e) {
            $this->add($e);
        }

        return $this;
    }

    /**
     * @param int $number
     * @return $this|SequenceInterface
     */
    public function take($number)
    {
        if ($number <= 0) {
            throw new \InvalidArgumentException(sprintf('$number must be greater than 0, but got %d.', $number));
        }

        return $this->createNew(array_slice($this->elements, 0, $number));
    }

    /**
     * Extracts element from the head while the passed callable returns true.
     *
     * @param callable $callable receives elements of this sequence as first argument, and returns true/false.
     *
     * @return $this|SequenceInterface
     */
    public function takeWhile(callable $callable)
    {
        $newElements = [];

        foreach ($this->elements as $v) {
            if ($callable($v) !== true) {
                break;
            }

            $newElements[] = $v;
        }

        return $this->createNew($newElements);
    }

    /**
     * @param int $number
     * @return $this|SequenceInterface
     */
    public function drop($number)
    {
        if ($number <= 0) {
            throw new \InvalidArgumentException(sprintf('The number must be greater than 0, but got %d.', $number));
        }

        return $this->createNew(array_slice($this->elements, $number));
    }

    /**
     * @param int $number
     * @return $this|SequenceInterface
     */
    public function dropRight($number)
    {
        if ($number <= 0) {
            throw new \InvalidArgumentException(sprintf('The number must be greater than 0, but got %d.', $number));
        }

        return $this->createNew(array_slice($this->elements, 0, -1 * $number));
    }

    /**
     * @param callable $callable
     * @return $this|SequenceInterface
     */
    public function dropWhile(callable $callable)
    {
        for ($i = 0; $i < $this->length; $i++) {
            if (true !== $callable($this->elements[$i])) {
                break;
            }
        }

        return $this->createNew(array_slice($this->elements, $i));
    }

    /**
     * @param int $size
     * @return $this|SequenceInterface<SequenceInterface<A>>
     */
    public function sliding($size)
    {
        if ($size <= 0) {
            throw new \InvalidArgumentException(
                sprintf('The number must be greater than 0, but got %d.', $size)
            );
        }

        $slices = new Sequence();

        $offset = 0;
        while ($offset < $this->length()) {
            $slices->add($this->createNew(array_slice($this->elements, $offset, $size)));
            $offset += $size;
        }

        return $slices;
    }

    /**
     * @param callable $callable
     * @return bool
     */
    public function exists(callable $callable)
    {
        foreach ($this as $elem) {
            if ($callable($elem) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return int
     * @deprecated Use Sequence::length()
     */
    public function count()
    {
        return $this->length();
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * @param $elements
     * @return $this|SequenceInterface
     */
    protected function createNew($elements)
    {
        return new static($elements);
    }
}
