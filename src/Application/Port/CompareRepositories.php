<?php

namespace App\Application\Port;

use App\Application\DataTransferObject\RepositoryComparisonDto;
use App\Application\DataTransferObject\RepositoryIdentifierDto;

Interface CompareRepositories
{
    /**
     * @param RepositoryIdentifierDto[] $repositoryIdentifiers
     * @return RepositoryComparisonDto
     */
    public function handle(array $repositoryIdentifiers): RepositoryComparisonDto;
}
