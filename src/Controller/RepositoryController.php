<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\CompareRepositories;
use App\Application\Exception\ApplicationException;
use App\Controller\Request\CompareRepositoriesRequest;
use App\Controller\Response\CompareRepositoriesResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RepositoryController extends AbstractController
{

    #[Route('/api/repositories/compare', methods : ['POST'])]
    public function compare(
        CompareRepositories $compareRepositories,
        Request $request
    ): JsonResponse {
        $compareRepositoriesRequest = CompareRepositoriesRequest::createFromRequest($request);

        try {
            $repositoryComparison = $compareRepositories->handle($compareRepositoriesRequest->getRepositoryIdentifiers());
        } catch (ApplicationException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }

        return new JsonResponse(new CompareRepositoriesResponse($repositoryComparison));
    }
}