<?php

namespace App\Domain\CheckListContext\Actions;

use App\Domain\CheckListContext\Entities\CheckListArray;
use App\Domain\CheckListContext\Rules\GetCheckListRules;
use App\Domain\CheckListContext\Strategies\GetCheckListStrategies;
use Exception;

class GetCheckListAction
{
    public function __construct(
        private GetCheckListRules $rules,
        private GetCheckListStrategies $stragies
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $limit, int $offset): CheckListArray
    {
        if (!$this->rules->limitMoreZero($limit)) {
            $this->stragies->throwLimitError();
        }
        if (!$this->rules->offsetMoreOrEqualZero($offset)) {
            $this->stragies->throwOffsetError();
        }
        return $this->stragies->getList($limit, $offset);
    }
}