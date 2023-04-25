<?php

namespace App\Domain\CheckListContext\Entities;

use ArrayObject;
use ReturnTypeWillChange;

class CheckListArray extends ArrayObject {
    #[ReturnTypeWillChange] public function offsetSet($key, $value) {
        if ($value instanceof CheckList) {
            parent::offsetSet($key, $value);
        }
        throw new \InvalidArgumentException('Value must be a Foo');
    }
}