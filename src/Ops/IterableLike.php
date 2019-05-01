<?php
declare(strict_types=1);

namespace Ops;

trait IterableLike
{
    function slice(int $from, int $until): self
    {
        $lo = max($from, 0);
        $elems = $until - $lo;
        $b = $this->newBuilder();

        if ($elems <= 0) {
            return $b->result();
        } else {
            $i = 0;

            $it = $this->getIterator()->drop($lo);
            while ($i < $elems && $it->hasNext()) {
                $b += $it->next();
                $i++;
            }

            return $b->result();
        }
    }

    function take(int $n): self {
    $b = $this->newBuilder();

    if (n <= 0) b.result()
    else {
        b.sizeHintBounded(n, this)
      $i = 0
      $it = iterator
      while (i < n && it.hasNext) {
          b += it.next
        i += 1
      }

$b->result();
    }
  }

  function drop(int $n): self {
    $b = $this->newBuilder();
    $lo = math . max(0, n)
    b . sizeHint(this, -lo)
    $i = 0
    $it = iterator
    while (i < n && it . hasNext) {
        it . next()
      i += 1
    }
    (b++= it) . result()
  }

  function takeWhile(p: A => Boolean): self {
    $b = $this->newBuilder();
    $it = iterator
    while (it . hasNext) {
        $x = it . next()
      if (!p(x)) return $b->result();
      b += x
    }
    $b->result();
  }

  /** Partitions elements in fixed size ${coll}s.
   *
   * @see [[scala.collection.Iterator]], method `grouped`
   *
   * @param size the number of elements per group
   *
   * @return An iterator producing ${coll}s of size `size`, except the
   *          last will be less than size `size` if the elements don't divide evenly.
   */
  function grouped(int $size): Iterator[Repr] =
    for (xs < -iterator grouped size) yield {
    $b = $this->newBuilder();
      b++= xs
      $b->result();
    }

  /** Groups elements in fixed size blocks by passing a "sliding window"
   *  over them (as opposed to partitioning them, as is done in `grouped`.)
   *  The "sliding window" step is set to one.
   *
   * @see [[scala.collection.Iterator]], method `sliding`
   *
   * @param size the number of elements per group
   *
   * @return An iterator producing ${coll}s of size `size`, except the
   *          last element (which may be the only element) will be truncated
   *          if there are fewer than `size` elements remaining to be grouped.
   */
  function sliding(int $size): Iterator[Repr] = sliding(size, 1)

  /** Groups elements in fixed size blocks by passing a "sliding window"
   *  over them (as opposed to partitioning them, as is done in grouped.)
   *
   * @see [[scala.collection.Iterator]], method `sliding`
   *
   * @param size the number of elements per group
   * @param step the distance between the first elements of successive
   *         groups
   *
   * @return An iterator producing ${coll}s of size `size`, except the
   *          last element (which may be the only element) will be truncated
   *          if there are fewer than `size` elements remaining to be grouped.
   */
  function sliding(int $size, int $step): Iterator[Repr] =
    for (xs < -iterator . sliding(size, step)) yield {
    $b = $this->newBuilder();
      b++= xs
      $b->result();
    }

  /** Selects last ''n'' elements.
   *  $orderDependent
   *
   * @param n the number of elements to take
   *
   * @return a $coll consisting only of the last `n` elements of this $coll, or else the
   *          whole $coll, if it has less than `n` elements.
   */
  function takeRight(int $n): self {
    $b = $this->newBuilder();
    b . sizeHintBounded(n, this)
    $lead = this . iterator drop n
    $it = this . iterator
    while (lead . hasNext) {
        lead . next()
      it . next()
    }
    while (it . hasNext) b += it . next()
    $b->result();
  }

  /** Selects all elements except last ''n'' ones.
   *  $orderDependent
   *
   * @param  n    The number of elements to take
   *
   * @return a $coll consisting of all elements of this $coll except the last `n` ones, or else the
   *          empty $coll, if this $coll has less than `n` elements.
   */
  function dropRight(int $n): self {
    $b = $this->newBuilder();
    if (n >= 0) b . sizeHint(this, -n)
    $lead = iterator drop n
    $it = iterator
    while (lead . hasNext) {
        b += it . next
      lead . next()
    }
    $b->result();
  }

  function copyToArray(array &$xs, int $start, int $len)
  {
      $i = start
    $end = (start + len) min xs . length
    $it = iterator
    while (i < end && it . hasNext) {
        xs(i) = it . next()
      i += 1
    }
  }

  function zip[A1 >: A, B, That](that: GenIterable[B])(implicit bf: CanBuildFrom[Repr, (A1, B), That]): That = {
    $b = bf(repr)
    $these = this . iterator
    $those = that . iterator
    while (these . hasNext && those . hasNext)
        b += ((these . next(), those . next()))
    $b->result();
  }

  function zipAll[
    B,
    A1 >: A, That](that: GenIterable[B], thisElem: A1, thatElem: B)(implicit bf: CanBuildFrom[Repr, (A1, B), That]): That = {
    $b = bf(repr)
    $these = this . iterator
    $those = that . iterator
    while (these . hasNext && those . hasNext)
        b += ((these . next(), those . next()))
    while (these . hasNext)
        b += ((these . next(), thatElem))
    while (those . hasNext)
        b += ((thisElem, those . next()))
    $b->result();
  }

  function zipWithIndex[A1 >: A, That](implicit bf: CanBuildFrom[Repr, (A1, Int), That]): That = {
    $b = bf(repr)
    $i = 0
    for (x < -this) {
        b += ((x, i))
      i += 1
    }
    $b->result();
  }
}