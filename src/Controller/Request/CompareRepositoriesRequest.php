<?php

declare(strict_types=1);

namespace App\Controller\Request;

use App\Application\DataTransferObject\RepositoryIdentifierDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CompareRepositoriesRequest
{
    /**
     * @var RepositoryIdentifierDto[]
     */
    private array $repositoryIdentifiers = [];

    private function __construct(Request $request)
    {
        $requestBody = json_decode($request->getContent());

        $this->validate($requestBody);

        $this->setRepositoryIdentifiers($requestBody);
    }

    public static function createFromRequest(Request $request): self
    {
        return new self($request);
    }

    /**
     * @return RepositoryIdentifierDto[]
     */
    public function getRepositoryIdentifiers(): array
    {
        return $this->repositoryIdentifiers;
    }

    private function setRepositoryIdentifiers(array $repositoryIdentifiers): void
    {
        foreach ($repositoryIdentifiers as $repositoryIdentifier) {
            $this->repositoryIdentifiers[] = new RepositoryIdentifierDto(
                $repositoryIdentifier->repositoryName,
                $repositoryIdentifier->repositoryOwner,
            );
        }
    }

    private function validate($body): void
    {
        if (!is_array($body)) {
            throw new BadRequestHttpException('Invalid request body provided. Array required.');
        }

        if (count($body) !== 2) {
            throw new BadRequestHttpException(
                sprintf('Invalid number of repository links. %u provided', count($body))
            );
        }

        foreach ($body as $repositoryIdentifier) {
            $this->validateRepositoryIdentifiers($repositoryIdentifier);
        }
    }

    private function validateRepositoryIdentifiers($repositoryIdentifier): void
    {
        if (!is_object($repositoryIdentifier)) {
            throw new BadRequestHttpException('Invalid request body');
        }

        if (!property_exists($repositoryIdentifier, 'repositoryName')) {
            throw new BadRequestHttpException('Repository name is required');
        }

        if (!is_string($repositoryIdentifier->repositoryName)) {
            throw new BadRequestHttpException(
                sprintf('Repository name need to be of string type. %s provided', gettype($repositoryIdentifier->repositoryName))
            );
        }

        if (!property_exists($repositoryIdentifier, 'repositoryOwner')) {
            throw new BadRequestHttpException('Repository owner is required');
        }

        if (!is_string($repositoryIdentifier->repositoryOwner)) {
            throw new BadRequestHttpException(
                sprintf('Repository owner need to be of string type. %s provided', gettype($repositoryIdentifier->repositoryOwner))
            );
        }
    }
}
