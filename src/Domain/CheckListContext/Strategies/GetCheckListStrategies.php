<?php

namespace App\Domain\CheckListContext\Strategies;

use App\Domain\CheckListContext\Entities\CheckListArray;
use App\Domain\CheckListContext\TechnologyAdapters\CheckListDatabaseManagerInterface;
use Exception;

class GetCheckListStrategies
{
    public function __construct(
        private  CheckListDatabaseManagerInterface $databaseManager,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function throwLimitError()
    {
        throw new Exception("Limit must be more 0");
    }

    /**
     * @throws Exception
     */
    public function throwOffsetError()
    {
        throw new Exception("Offset must be more or equal 0");
    }

    public function getList(int $limit, int $offset): CheckListArray
    {
        return $this->databaseManager->getList($limit, $offset);
    }
}