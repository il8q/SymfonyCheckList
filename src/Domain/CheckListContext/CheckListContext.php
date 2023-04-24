<?php
namespace App\Service;
namespace App\Domain\CheckListContext;

use Exception;

class CheckListContext
{
    public function getCheckLists(): array
    {
        throw new Exception('Not implement');
        $result = [];
        $result[] = ['sdf0'];
        return $result;
    }

    public function deleteCheckList(): bool
    {
        throw new Exception('Not implement');
        return false;
    }

    public function createCheckList(): array
    {
        throw new Exception('Not implement');
        return [];
    }
}