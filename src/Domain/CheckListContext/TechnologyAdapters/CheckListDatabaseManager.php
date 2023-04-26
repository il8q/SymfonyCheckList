<?php

namespace App\Domain\CheckListContext\TechnologyAdapters;

use App\Domain\CheckListContext\Entities\CheckListArray;
use App\Repository\CheckListRepository;

class CheckListDatabaseManager implements CheckListDatabaseManagerInterface
{
    public function __construct(
        private CheckListRepository $checkListRepository,
    )
    {
    }

    public function getList(int $limit, int $offset): CheckListArray
    {
        $result = new CheckListArray();
        $queryResult = $this->checkListRepository->findBy([], limit: $limit, offset: $offset);

        if ($queryResult) {
            foreach ($queryResult as $checkList) {
                $result[] = $checkList;
            }
        }
        return $result;
    }
}