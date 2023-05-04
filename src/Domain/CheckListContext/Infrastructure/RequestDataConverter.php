<?php

namespace App\Domain\CheckListContext\Infrastructure;

use Closure;
use Exception;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Преобразует данные из Request в пакет данных для контекста/доменной модели.
 * Преобразует строки в числа, числа с плавающей точкой. если это указано в правилах валидации.
 */
class RequestDataConverter
{
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
            $rulesForVariable = $rules->fields[$name]->constraints;
            $type = self::extractTypeForRules($name, $rulesForVariable);
            $result[$name] = $this->convertVariable(
                $requestData,
                $name,
                self::getRuleCollectionFor($type, $name),
                self::getConvertFunctionFor($type),
            );
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    private static function extractTypeForRules(string $name, array $rules): string
    {
        foreach ($rules as $rule) {
            if ($rule instanceof Type) {
                return $rule->type;
            }
        }
        throw new Exception(sprintf("%s not have type", $name));
    }

    /**
     * @throws BadReqeustException
     */
    private function convertVariable(
        array $requestData,
        string $name,
        callable $checkFunction,
        callable $convertFunction
    ): mixed
    {
        $variable = $requestData[$name];
        $checkFunction($variable);
        return $convertFunction($variable);
    }

    /**
     * @param string $type
     * @param string $name
     * @return callable
     */
    public static function getRuleCollectionFor(string $type, string $name): Closure
    {
        return match ($type) {
            'integer' => function($value) use ($name) {
                $result = preg_match("/^[-+]?[0-9]+$/", $value);
                if (!$result) {
                    throw new BadReqeustException(sprintf("%s not integer", $name));
                }
                return true;
            },
            'float' => function($value) use ($name) {
                $result = preg_match("/^[-+]?[0-9]+.[0-9]*$/", $value);
                if (!$result) {
                    throw new BadReqeustException(sprintf("%s not float", $name));
                }
                return true;
            },
            'string' => function($value) use ($name) {
                if (gettype($value) !== 'string') {
                    throw new BadReqeustException(sprintf("%s not string", $name));
                }
                return true;
            },
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