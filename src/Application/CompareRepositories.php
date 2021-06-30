<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\DataTransferObject\RepositoryComparisonDto;
use App\Application\DataTransferObject\RepositoryIdentifierDto;
use App\Application\Port\CompareRepositories as CompareRepositoriesInterface;
use App\Application\Port\RepositoryProvider;
use App\Domain\Entity\Repository;
use App\Domain\Service\RepositoryComparator;

class CompareRepositories implements CompareRepositoriesInterface
{
    private RepositoryProvider $repositoryProvider;
    private RepositoryComparator $repositoryComparator;

    public function __construct(RepositoryProvider $repositoryProvider, RepositoryComparator $repositoryComparator)
    {
        $this->repositoryProvider = $repositoryProvider;
        $this->repositoryComparator = $repositoryComparator;
    }

    /**
     * @param RepositoryIdentifierDto[] $repositoryIdentifiers
     * @return RepositoryComparisonDto
     */
    public function handle(array $repositoryIdentifiers): RepositoryComparisonDto
    {
        $repositories = $this->getRepositories($repositoryIdentifiers);

        return new RepositoryComparisonDto(
            $repositories,
            $this->repositoryComparator->getMostPopularRepository($repositories)
        );
    }

    /**
     * @param RepositoryIdentifierDto[] $repositoryIdentifiers
     * @return Repository[]
     */
    private function getRepositories(array $repositoryIdentifiers): array
    {
        $repositories = [];

        foreach ($repositoryIdentifiers as $repositoryIdentifier) {
            $repositories[] = $this->repositoryProvider->get(
                $repositoryIdentifier->getRepositoryOwner(),
                $repositoryIdentifier->getRepositoryName()
            );
        }

        return $repositories;
    }
}
