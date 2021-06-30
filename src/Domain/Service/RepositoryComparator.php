<?php

namespace App\Domain\Service;

use App\Domain\Entity\Repository;

interface RepositoryComparator
{
    /**
     * @param Repository[] $repositories
     */
    public function getMostPopularRepository(array $repositories): Repository;
}