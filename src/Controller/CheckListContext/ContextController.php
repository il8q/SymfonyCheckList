<?php

namespace App\Controller\CheckListContext;

use App\Controller\BaseController;
use App\Domain\CheckListContext\CheckListContext;
use App\Domain\CheckListContext\EntitySerializer;
use Symfony\Component\HttpFoundation\Request;
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
    public function createCheckLists(
        Request $request,
        CheckListContext $context,
        EntitySerializer $serializer,

    ): JsonResponse
    {
        return $this->wrapResultForResponse(function () use ($request, $context) {
            $attributes = [
                'title' => $request->request->get('title')
            ];
            return ['checkList' => $context->createCheckList($attributes)];
        });
    }

    #[Route('/check-lists/delete')]
    public function deleteCheckLists(
        Request $request,
        CheckListContext $context
    ): JsonResponse
    {
        $id = $request->request->get('id');
        return $this->wrapResultForResponse(function () use ($id, $context) {
            return ['success' => $context->deleteCheckList($id)];
        });
    }
}
