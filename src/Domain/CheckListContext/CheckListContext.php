<?php
namespace App\Service;
namespace App\Domain\CheckListContext;

use App\Domain\CheckListContext\Actions\CreateCheckListAction;
use App\Domain\CheckListContext\Actions\DeleteCheckListAction;
use App\Domain\CheckListContext\Actions\GetCheckListAction;
use App\Domain\CheckListContext\Entities\CheckList;
use Exception;

class CheckListContext
{
    public function __construct(
        private GetCheckListAction $getCheckListAction,
        private DeleteCheckListAction $deleteCheckList,
        private CreateCheckListAction $createCheckList,
    )
    {
        $contextBuilder = new ContextBuilder();
        $this->getCheckListAction = $contextBuilder->createGetCheckListAction();
        $this->deleteCheckList = $contextBuilder->createDeleteCheckListAction();
        $this->createCheckList = $contextBuilder->createCreateCheckListAction();
    }

    /**
     * @throws Exception
     */
    public function getCheckLists(): array
    {
        return $this->getCheckListAction->execute();
    }

    /**
     * @throws Exception
     */
    public function deleteCheckList(int $id): bool
    {
        return $this->deleteCheckList->execute($id);
    }

    /**
     * @throws Exception
     */
    public function createCheckList(array $attributes): CheckList
    {
        return $this->createCheckList->execute($attributes);
    }
}