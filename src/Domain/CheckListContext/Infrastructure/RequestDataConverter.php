<?php

namespace App\Domain\CheckListContext\Infrastructure;

use Closure;
use Exception;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Преобразует данные из Request в пакет данных для контекста/доменной модели.
 * Преобразует строки в числа, числа с плавающей точкой. если это указано в правилах валидации.
 */
class RequestDataConverter
{
    public function __construct(
        private ValidatorInterface $validator,
    )
    {
    }

    /**
     * @throws Exception
     */
    private static function extractAndCheckType(string $name, array $rules): string
    {
        foreach ($rules as $rule) {
            if ($rule instanceof Type) {
               return $rule->type;
            }
        }
        throw new Exception(sprintf("%s not have type", $name));
    }

    /**
     * @param array $requestData
     * @param Collection $rules
     * @return array
     * @throws Exception
     */
    public function convert(array $requestData, Collection $rules): array
    {
        $result = [];
        foreach ($requestData as $name => $value) {
            $type = self::extractAndCheckType($name, $rules->fields[$name]);
            var_dump($name);
            $result[$name] = $this->convertVariable(
                $requestData,
                $name,
                self::getRuleCollectionFor($type),
                self::getConvertFunctionFor($type),
            );
        }

        return $result;
    }

    private function convertVariable(
        array $requestData,
        string $name,
        Collection $rules,
        callable $convertFunction
    ): mixed
    {
        $variable = $requestData[$name];
        $this->validator->validate($variable, $rules);
        return $convertFunction($variable);
    }

    /**
     * @param string $type
     * @return Collection
     */
    public static function getRuleCollectionFor(string $type): Collection
    {
        return match ($type) {
            'integer' => new Collection([
                new Type(['type' => 'string']),
                new Regex("(\d)+")
            ]),
            'float' => new Collection([
                new Type(['type' => 'string']),
                new Regex("(\d)+.(\d)*")
            ]),
            'string' => new Collection([
                new Type(['type' => 'string'])
            ]),
        };
    }

    /**
     * @param string $type
     * @return Closure
     */
    public static function getConvertFunctionFor(string $type): Closure
    {
        return match ($type) {
            'integer' => function ($value) {
                return (int)$value;
            },
            'float' => function ($value) {
                return (float)$value;
            },
            'string' => function ($value) {
                return (string)$value;
            },
        };
    }
}