<?php

namespace modules\lib;

abstract class enum
{

    final public function __construct($value)
    {
        $this->value = $value;
    }

    final public function __toString()
    {
        return $this->value;
    }
}