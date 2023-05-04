<?php

namespace App\Domain\CheckListContext\Actions;

use App\Domain\CheckListContext\Entities\CheckList;
use App\Domain\CheckListContext\Rules\CreateCheckListRules;
use App\Domain\CheckListContext\Strategies\CreateCheckListStrategies;
use Exception;

class CreateCheckListAction
{
    public function __construct(
        private CreateCheckListRules $rules,
        private CreateCheckListStrategies $stragies
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(array $attributes): CheckList
    {
        if (!$this->rules->titleIsNotEmpty($attributes['title'])) {
            $this->stragies->throwTitleEmptyError();
        }
        return $this->stragies->createCheckList($attributes);
    }
}