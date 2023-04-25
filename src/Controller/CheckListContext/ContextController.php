<?php

namespace App\Controller\CheckListContext;

use App\Controller\BaseController;
use App\Domain\CheckListContext\CheckListContext;
use App\Domain\CheckListContext\EntitySerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class ContextController extends BaseController
{
    #[Route('/check-lists/get-lists')]
    public function getCheckLists(Request $request, CheckListContext $context): JsonResponse
    {
        return $this->wrapResultForResponse(
            $request->query->all(),
            new Collection([]),
            function ($inputData) use ($context) {
                return ['checkList' => $context->getCheckLists()];
            }
        );
    }

    #[Route('/check-lists/create')]
    public function createCheckLists(
        Request $request,
        CheckListContext $context,
        EntitySerializer $serializer,

    ): JsonResponse
    {
        return $this->wrapResultForResponse(
            $request->request->all(),
            new Collection([
                'title' => [new Required(new Type(['type' => 'string'])), new NotBlank()],
            ]),
            function ($inputData) use ($context) {
                return ['checkList' => $context->createCheckList($inputData)];
            }
        );
    }

    #[Route('/check-lists/delete')]
    public function deleteCheckLists(
        Request $request,
        CheckListContext $context
    ): JsonResponse
    {
        return $this->wrapResultForResponse(
            ['id' => $request->request->getInt('id')],
            new Collection([
                'id' => [new Required(new Type(['type' => 'integer'])), new Positive()],
            ]),
            function ($inputData) use ($context) {
                return ['success' => $context->deleteCheckList($inputData['id'])];
            }
        );
    }
}
