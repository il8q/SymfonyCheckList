<?php

namespace App\Domain\CheckListContext\Actions;

use Exception;

class DeleteCheckListAction
{
    public function execute(int $id): bool
    {
        throw new Exception('Not implement');
        return false;
    }
}