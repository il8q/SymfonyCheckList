<?php

namespace App\Domain\CheckListContext\Entities\Factories;

use App\Domain\CheckListContext\Entities\CheckList;
use DateTimeImmutable;

class CheckListFactory
{
    public static function create(array $attributes): CheckList
    {
        $result = new CheckList();
        $result->setTitle($attributes['title']);
        $result->setCreatedAt((new DateTimeImmutable())->setTimestamp(time()));
        $result->setUpdatedAt((new DateTimeImmutable())->setTimestamp(time()));
        return $result;
    }
}