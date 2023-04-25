<?php

namespace App\Domain\CheckListContext\Actions;

use App\Domain\CheckListContext\Entities\CheckList;
use Exception;

class CreateCheckListAction
{
    public function execute(array $attributes): CheckList
    {
        throw new Exception('Not implement');
        return new CheckList();
    }
}