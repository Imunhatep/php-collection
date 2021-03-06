<?php
namespace Collection\ObjectBasicsHandler;

use Collection\ObjectBasicsHandlerInterface;

class IdentityHandlerInterface implements ObjectBasicsHandlerInterface
{
    public function hash($object)
    {
        return spl_object_hash($object);
    }

    public function equals($a, $b)
    {
        return $a === $b;
    }
}
