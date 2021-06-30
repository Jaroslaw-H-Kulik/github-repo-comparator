<?php

namespace App\Application\Port;

use App\Domain\Entity\Repository;

Interface RepositoryProvider
{
    public function get(string $repositoryOwner, string $repositoryName): Repository;
}
