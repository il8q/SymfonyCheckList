<?php

namespace App\Domain\CheckListContext\TechnologyAdapters;

use App\Domain\CheckListContext\Entities\CheckListArray;

interface CheckListDatabaseManagerInterface
{
    public function getList(int $limit, int $offset): CheckListArray;
}