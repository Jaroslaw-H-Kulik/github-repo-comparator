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
        foreach ($repositories as $repository) {
            $this->repositories[] = RepositoryDto::createFromRepository($repository);
        }

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
}