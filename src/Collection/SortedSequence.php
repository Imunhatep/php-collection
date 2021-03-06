<?php
namespace Collection;

/**
 * A sequence with a fixed sort-order.
 *
 * @author Artyom Sukharev , J. M. Schmitt
 */
class SortedSequence extends AbstractSequence implements \JsonSerializable
{
    private $sortFunc;

    public function __construct(callable $sortFunc, array $elements = [])
    {
        $this->sortFunc = $sortFunc;

        parent::__construct($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function add($newElement)
    {
        /** @var callable $sortFunc */
        $sortFunc = $this->sortFunc;

        $added = false;
        $newElements = [];

        foreach ($this->elements as $element) {
            // We insert the new element before the first element that is greater than itself.
            if (!$added && ((int)$sortFunc($newElement, $element) < 0)) {
                $newElements[] = $newElement;
                $added = true;
            }

            $newElements[] = $element;
        }

        if (!$added) {
            $newElements[] = $newElement;
        }

        $this->elements = $newElements;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll($addedElements)
    {
        /** @var callable $sortFunc */
        $sortFunc = $this->sortFunc;

        usort($addedElements, $sortFunc);

        $newElements = [];
        foreach ($this->elements as $element) {
            if (!empty($addedElements)) {
                foreach ($addedElements as $i => $newElement) {
                    // If the currently looked at $newElement is not smaller than $element, then we can also conclude
                    // that all other new elements are also not smaller than $element as we have ordered them before.
                    if ((int)$sortFunc($newElement, $element) > -1) {
                        break;
                    }

                    $newElements[] = $newElement;
                    unset($addedElements[$i]);
                }
            }

            $newElements[] = $element;
        }

        if (!empty($addedElements)) {
            foreach ($addedElements as $newElement) {
                $newElements[] = $newElement;
            }
        }

        $this->elements = $newElements;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function createNew($elements)
    {
        return new static($this->sortFunc, $elements);
    }

    public function jsonSerialize()
    {
        return $this->all();
    }
}
