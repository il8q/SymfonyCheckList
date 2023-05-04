<?php

namespace App\Domain\CheckListContext\Strategies;

use App\Domain\CheckListContext\Entities\CheckList;
use App\Domain\CheckListContext\Entities\Factories\CheckListFactory;
use App\Domain\CheckListContext\TechnologyAdapters\CheckListDatabaseManagerInterface;
use Exception;

class CreateCheckListStrategies
{
    public function __construct(
        private CheckListDatabaseManagerInterface $databaseManager,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function throwTitleEmptyError()
    {
        throw new Exception("Title must be not empty");
    }

    public function createCheckList(array $attributes): CheckList
    {
        $checkList = CheckListFactory::create($attributes);
        return $this->databaseManager->createList($checkList);
    }
}