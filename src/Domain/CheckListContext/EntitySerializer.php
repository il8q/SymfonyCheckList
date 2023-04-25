<?php
namespace App\Service;
namespace App\Domain\CheckListContext;

use App\Domain\CheckListContext\Entities\CheckList;

class EntitySerializer
{
    public static function serialize(CheckList $checkList): array
    {
        $result = [];
        $result['id'] = $checkList->getId();
        $result['title'] = $checkList->getTitle();
        $result['createdAt'] = $checkList->getCreatedAt();
        $result['updatedAt'] = $checkList->getUpdatedAt();
        return $result;
    }
}