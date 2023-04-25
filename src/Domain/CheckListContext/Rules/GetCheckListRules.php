<?php

namespace App\Domain\CheckListContext\Rules;

use Exception;

class GetCheckListRules
{

    /**
     * @throws Exception
     */
    public function limitMoreZero(int $limit): bool
    {
        return $limit > 0;
    }

    public function offsetMoreOrEqualZero(int $offset): bool
    {
        return $offset >= 0;
    }
}