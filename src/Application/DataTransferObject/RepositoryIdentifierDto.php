<?php

declare(strict_types=1);

namespace App\Application\DataTransferObject;

Class RepositoryIdentifierDto
{
    private ?string $repositoryName;
    private ?string $repositoryOwner;

    public function __construct(?string $repositoryName, ?string $repositoryOwner)
    {
        $this->repositoryName = $repositoryName;
        $this->repositoryOwner = $repositoryOwner;
    }

    public function getRepositoryName(): ?string
    {
        return $this->repositoryName;
    }

    public function getRepositoryOwner(): ?string
    {
        return $this->repositoryOwner;
    }
}
