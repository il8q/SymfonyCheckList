<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class BaseController extends AbstractController
{
    protected function wrapResultForResponse(
        array $inputData,
        Collection $rules,
        callable $func
    ): JsonResponse
    {
        try {
            $this->validate($inputData, $rules);
            $result = $func($inputData);
            return $this->json(
                $result,
                Response::HTTP_OK,
            );
        } catch (\Exception $exception) {
            return $this->json(
                [
                    'error' => $exception->getMessage(),
                    'trace' => $exception->getTrace(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    protected function validate($value, $constraints)
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($value, $constraints);
        if (count($violations) > 0) {
            throw new ValidatorException($violations);
        }
    }
}