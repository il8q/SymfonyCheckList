<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    protected function wrapResultForResponse($func): JsonResponse
    {
        try {
            $result = $func();
            return $this->json(
                ['data' => $result],
                Response::HTTP_OK,
            );
        } catch (\Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}