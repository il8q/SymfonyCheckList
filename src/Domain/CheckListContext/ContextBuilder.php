<?php

namespace App\Domain\CheckListContext;

use App\Domain\CheckListContext\Actions\CreateCheckListAction;
use App\Domain\CheckListContext\Actions\DeleteCheckListAction;
use App\Domain\CheckListContext\Actions\GetCheckListAction;

class ContextBuilder
{
    public function createGetCheckListAction(): GetCheckListAction
    {
        return new GetCheckListAction();
    }

    public function createDeleteCheckListAction(): DeleteCheckListAction
    {
        return new DeleteCheckListAction();
    }

    public function createCreateCheckListAction(): CreateCheckListAction
    {
        return new CreateCheckListAction();
    }
}