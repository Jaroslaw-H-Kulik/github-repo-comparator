<?php

namespace App\Application\Port;

use App\Application\DataTransferObject\RepositoryComparisonDto;

Interface CompareRepositories
{
    /**
     * @param string[] $repositoryIdentifiers
     * @return RepositoryComparisonDto
     */
    public function handle(array $repositoryIdentifiers): RepositoryComparisonDto;
}
