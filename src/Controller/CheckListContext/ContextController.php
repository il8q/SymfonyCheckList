<?php

namespace App\Controller\CheckListContext;

use App\Controller\BaseController;
use App\Domain\CheckListContext\CheckListContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ContextController extends BaseController
{
    #[Route('/check-lists/get-lists')]
    public function getCheckLists(CheckListContext $context): JsonResponse
    {
        return $this->wrapResultForResponse(function () use ($context) {
            return ['checkList' => $context->getCheckLists()];
        });
    }

    #[Route('/check-lists/create')]
    public function createCheckLists(CheckListContext $context): JsonResponse
    {
        return $this->wrapResultForResponse(function () use ($context) {
            return ['checkList' => $context->createCheckList()];
        });
    }

    #[Route('/check-lists/delete')]
    public function deleteCheckLists(CheckListContext $context): JsonResponse
    {
        return $this->wrapResultForResponse(function () use ($context) {
            return ['success' => $context->deleteCheckList()];
        });
    }
}
