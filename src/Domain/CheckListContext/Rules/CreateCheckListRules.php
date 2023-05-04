<?php

namespace App\Domain\CheckListContext\Rules;

use Exception;

class CreateCheckListRules
{
    public function titleIsNotEmpty(?string $title): bool
    {
        // условие именно такое чтобы значение "0" было валидным
        return !is_null($title) && (strlen($title) > 0);
    }
}