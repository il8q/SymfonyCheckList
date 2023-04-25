<?php

namespace App\Domain\CheckListContext;

use App\Domain\CheckListContext\Actions\CreateCheckListAction;
use App\Domain\CheckListContext\Actions\DeleteCheckListAction;
use App\Domain\CheckListContext\Actions\GetCheckListAction;
use App\Domain\CheckListContext\Entities\CheckList;
use App\Domain\CheckListContext\Rules\GetCheckListRules;
use App\Domain\CheckListContext\Strategies\GetCheckListStrategies;
use App\Domain\CheckListContext\TechnologyAdapters\CheckListDatabaseManager;
use App\Domain\CheckListContext\TechnologyAdapters\CheckListDatabaseManagerInterface;
use App\Repository\CheckListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;

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

    /**
     * @throws NotSupported
     */
    private function getOrCreateCheckListDatabaseManager(): CheckListDatabaseManagerInterface
    {
        if ($this->checkListDatabaseManager) {
            return $this->checkListDatabaseManager;
        }
        return new CheckListDatabaseManager($this->getOrCreateCheckListRepository());
    }

    /**
     * @throws NotSupported
     */
    private function getOrCreateCheckListRepository(): CheckListRepository
    {
        if ($this->checkListRepository) {
            return $this->checkListRepository;
        }
        return $this->entityManager->getRepository(CheckList::class);
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