<?php

namespace App\Controller;

use App\Domain\CheckListContext\Infrastructure\BadReqeustException;
use App\Domain\CheckListContext\Infrastructure\RequestDataConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class BaseController extends AbstractController
{
    private static function addDefaultValues(array $convertData, array $defaultValues): array
    {
        $result = [];
        foreach ($defaultValues as $name => $value) {
            if (!array_key_exists($name, $convertData)) {
                $result[$name] = $value;
            }
        }
        return array_merge($convertData, $result);
    }

    protected function wrapResultForResponse(
        array $inputData,
        Collection $rules,
        array $defaultValues,
        callable $func
    ): JsonResponse
    {
        try {
            $convertData = $this->validateAndConvert($inputData, $rules, $defaultValues);
            $result = $func($convertData);
            return $this->json(
                $result,
                Response::HTTP_OK,
            );
        } catch (BadReqeustException $exception) {
            return $this->json(
                [
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
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

    /**
     * @throws \Exception
     */
    protected function validateAndConvert(
        array $inputData,
        Collection $constraints,
        array $defaultValues,
    ): array
    {
        $validator = Validation::createValidator();
        $requestDataConverter = new RequestDataConverter($validator);
        $convertData = $requestDataConverter->convert($inputData, $constraints);
        $convertData = self::addDefaultValues($convertData, $defaultValues);

        $violations = $validator->validate($convertData, $constraints);
        if (count($violations) > 0) {
            throw new BadReqeustException($violations);
        }
        return $convertData;
    }
}