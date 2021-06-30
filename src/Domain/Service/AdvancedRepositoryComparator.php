<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Repository;

class AdvancedRepositoryComparator implements RepositoryComparator
{
    /**
     * @param Repository[] $repositories
     */
    public function getMostPopularRepository(array $repositories): Repository
    {
        $mostPopularRepository = null;

        foreach ($repositories as $repository) {
            $mostPopularRepository = $mostPopularRepository ?? $repository;

            if ($this->getPopularityScore($repository) > $this->getPopularityScore($mostPopularRepository)) {
                $mostPopularRepository = $repository;
            }
        }

        return $mostPopularRepository;
    }

    private function getPopularityScore(Repository $repository): int
    {
        return $repository->getOpenPullRequests()
            + $repository->getClosedPullRequests()
            + $repository->getForks()
            + $repository->getStars()
            + $repository->getWatchers();
    }

}