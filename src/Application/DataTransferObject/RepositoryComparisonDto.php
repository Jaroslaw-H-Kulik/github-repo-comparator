<?php

declare(strict_types=1);

namespace App\Application\DataTransferObject;

use App\Domain\Entity\Repository;

class RepositoryComparisonDto
{
    /**
     * @var RepositoryDto[]
     */
    private array $repositories;
    private RepositoryDto $mostPopularRepository;

    /**
     * @param Repository[] $repositories
     * @param Repository $mostPopularRepository
     */
    public function __construct(array $repositories, Repository $mostPopularRepository)
    {
        $this->repositories = $this->convertRepositoriesToDtos($repositories);
        $this->mostPopularRepository = RepositoryDto::createFromRepository($mostPopularRepository);
    }

    /**
     * @return RepositoryDto[]
     */
    public function getRepositories(): array
    {
        return $this->repositories;
    }

    public function getMostPopularRepository(): RepositoryDto
    {
        return $this->mostPopularRepository;
    }

    /**
     * @param Repository[]
     * @return RepositoryDto[]
     */
    private function convertRepositoriesToDtos(array $repositories): array
    {
        $result = [];

        foreach ($repositories as $repository) {
            $result[] = RepositoryDto::createFromRepository($repository);
        }

        return $result;
    }
}