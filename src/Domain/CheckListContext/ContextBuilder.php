<?php

namespace App\Domain\CheckListContext;

use App\Domain\CheckListContext\Actions\CreateCheckListAction;
use App\Domain\CheckListContext\Actions\DeleteCheckListAction;
use App\Domain\CheckListContext\Actions\GetCheckListAction;
use App\Domain\CheckListContext\Entities\CheckList;
use App\Domain\CheckListContext\Rules\CreateCheckListRules;
use App\Domain\CheckListContext\Rules\GetCheckListRules;
use App\Domain\CheckListContext\Strategies\CreateCheckListStrategies;
use App\Domain\CheckListContext\Strategies\GetCheckListStrategies;
use App\Domain\CheckListContext\TechnologyAdapters\CheckListDatabaseManager;
use App\Domain\CheckListContext\TechnologyAdapters\CheckListDatabaseManagerInterface;
use App\Repository\CheckListRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContextBuilder
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ?CheckListDatabaseManagerInterface $checkListDatabaseManager = null,
        private ?CheckListRepository $checkListRepository = null,
    )
    {
    }

    public function createGetCheckListAction(): GetCheckListAction
    {
        return new GetCheckListAction(
            $this->createGetCheckListRules(),
            $this->createGetCheckListStrategies()
        );
    }

    private function createGetCheckListRules(): GetCheckListRules
    {
        return new GetCheckListRules();
    }


    private function createGetCheckListStrategies(): GetCheckListStrategies
    {
        return new GetCheckListStrategies(
            $this->getOrCreateCheckListDatabaseManager()
        );
    }


    private function getOrCreateCheckListDatabaseManager(): CheckListDatabaseManagerInterface
    {
        if ($this->checkListDatabaseManager) {
            return $this->checkListDatabaseManager;
        }
        return new CheckListDatabaseManager(
            $this->getOrCreateCheckListRepository(),
            $this->entityManager
        );
    }

    private function getOrCreateCheckListRepository(): CheckListRepository
    {
        if ($this->checkListRepository) {
            return $this->checkListRepository;
        }
        /** @var CheckListRepository $result */
        $result = $this->entityManager->getRepository(CheckList::class);
        return $result;
    }

    public function createDeleteCheckListAction(): DeleteCheckListAction
    {
        return new DeleteCheckListAction();
    }

    public function createCreateCheckListAction(): CreateCheckListAction
    {
        return new CreateCheckListAction(
            $this->createCreateCheckListRules(),
            $this->createCreateCheckListStrategies(),
        );
    }

    private function createCreateCheckListRules(): CreateCheckListRules
    {
        return new CreateCheckListRules();
    }

    private function createCreateCheckListStrategies(): CreateCheckListStrategies
    {
        return new CreateCheckListStrategies(
            $this->getOrCreateCheckListDatabaseManager()
        );
    }
}