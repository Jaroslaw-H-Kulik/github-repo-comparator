<?php

declare(strict_types=1);

namespace App\Controller\Response;

use App\Application\DataTransferObject\RepositoryComparisonDto;
use JsonSerializable;

class CompareRepositoriesResponse implements JsonSerializable
{
    private RepositoryComparisonDto $repositoryComparisonDto;

    public function __construct(RepositoryComparisonDto $repositoryComparisonDto)
    {
        $this->repositoryComparisonDto = $repositoryComparisonDto;
    }

    public function jsonSerialize()
    {
        return (object) [
            'repositories' => $this->prepareRepositoryRepresentation(),
            'mostPopularRepository' => $this->repositoryComparisonDto->getMostPopularRepository()->getName()
        ];
    }

    private function prepareRepositoryRepresentation(): array
    {
        $repositories = [];

        foreach ($this->repositoryComparisonDto->getRepositories() as $repository) {
            $repositories[] = (object) [
                'name' => $repository->getName(),
                'forks' => $repository->getForks(),
                'watchers' => $repository->getWatchers(),
                'stars' => $repository->getStars(),
                'closedPullRequests' => $repository->getClosedPullRequests(),
                'openPullRequests' => $repository->getOpenPullRequests(),
                'releaseDate' => $repository->getReleaseDate(),
            ];
        }

        return $repositories;
    }
}