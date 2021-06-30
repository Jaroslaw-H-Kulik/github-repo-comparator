<?php

declare(strict_types=1);

namespace App\Domain\Entity;

Class Repository
{
    private string $name;
    private int $forks;
    private int $stars;
    private int $watchers;
    private string $releaseDate;
    private int $openPullRequests;
    private int $closedPullRequests;

    public function __construct(
        string $name,
        int $forks,
        int $stars,
        int $watchers,
        string $releaseDate,
        int $openPullRequests,
        int $closedPullRequests
    ) {
        $this->name = $name;
        $this->forks = $forks;
        $this->stars = $stars;
        $this->watchers = $watchers;
        $this->releaseDate = $releaseDate;
        $this->openPullRequests = $openPullRequests;
        $this->closedPullRequests = $closedPullRequests;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getForks(): int
    {
        return $this->forks;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function getWatchers(): int
    {
        return $this->watchers;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getOpenPullRequests(): int
    {
        return $this->openPullRequests;
    }

    public function getClosedPullRequests(): int
    {
        return $this->closedPullRequests;
    }
}
