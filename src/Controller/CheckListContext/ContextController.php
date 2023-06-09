<?php

namespace App\Controller\CheckListContext;

use App\Controller\BaseController;
use App\Domain\CheckListContext\CheckListContext;
use App\Domain\CheckListContext\Infrastructure\BadReqeustException;
use App\Domain\CheckListContext\Infrastructure\EntitySerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class ContextController extends BaseController
{
    #[Route('/check-lists/get-lists')]
    public function getCheckLists(
        Request $request,
        CheckListContext $context,
        EntitySerializer $serializer
    ): JsonResponse
    {
        return $this->wrapResultForResponse(
            $request->query->all(),
            new Collection([
                'limit' => [new Type(['type' => 'integer']), new Positive()],
                'offset' => [new Type(['type' => 'integer']), new PositiveOrZero()],
            ]),
            [
                'limit' => 10,
                'offset' => 0,
            ],
            function ($inputData) use ($serializer, $context) {
                $result = $context->getCheckLists(
                    $inputData['limit'],
                    $inputData['offset']
                );
                return $serializer->serializeForList($result);
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
                'title' => [new Required(), new Type(['type' => 'string']), new NotBlank()],
            ]),
            [],
            function ($inputData) use ($serializer, $context) {
                $checkList = $context->createCheckList($inputData);
                return ['checkList' => $serializer->serializeFull($checkList)];
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
            [],
            function ($inputData) use ($context) {
                return ['success' => $context->deleteCheckList($inputData['id'])];
            }
        );
    }
}
