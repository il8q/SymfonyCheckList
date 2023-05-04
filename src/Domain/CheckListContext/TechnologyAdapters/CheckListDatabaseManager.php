<?php

namespace App\Domain\CheckListContext\TechnologyAdapters;

use App\Domain\CheckListContext\Entities\CheckList;
use App\Domain\CheckListContext\Entities\CheckListArray;
use App\Repository\CheckListRepository;
use Doctrine\ORM\EntityManagerInterface;

class CheckListDatabaseManager implements CheckListDatabaseManagerInterface
{
    public function __construct(
        private CheckListRepository $checkListRepository,
        private EntityManagerInterface $entityManager,
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

    public function createList(CheckList $checkList): CheckList
    {
        $this->entityManager->persist($checkList);
        $this->entityManager->flush($checkList);
        return $checkList;
    }
}