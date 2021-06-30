<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Exception\ApplicationException;
use App\Application\Exception\RepositoryNotFoundException;
use App\Application\Port\RepositoryProvider;
use App\Domain\Entity\Repository;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

Class GithubApiClient implements RepositoryProvider
{
    private const ENDPOINT = 'https://api.github.com/repos/%s/%s';

    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function get(string $repositoryOwner, string $repositoryName): Repository
    {
        $baseUrl = sprintf(self::ENDPOINT, $repositoryOwner, $repositoryName);

        $repositoryData = $this->getRepositoryData($baseUrl, $repositoryName);

        return new Repository(
            $repositoryData['name'],
            $repositoryData['forks'],
            $repositoryData['stars'],
            $repositoryData['watchers'],
            $this->getLatestRelease($baseUrl, $repositoryName),
            $this->getNumberOfPullRequests($baseUrl, $repositoryName),
            $this->getNumberOfPullRequests($baseUrl, $repositoryName, false)
        );
    }

    private function getRepositoryData(string $url, string $repositoryName): array
    {
        $responseBody = $this->fetchResponse($url, $repositoryName);

        return [
            'name' => $responseBody->name,
            'forks' => $responseBody->forks_count,
            'stars' => $responseBody->stargazers_count,
            'watchers' => $responseBody->watchers_count
        ];
    }

    private function getNumberOfPullRequests(string $baseUrl, string $repositoryName, bool $fetchOpen = true): int
    {
        $state = $fetchOpen ? 'open' : 'closed';

        $url = $baseUrl . '/pulls?' . http_build_query(['state' => $state]);

        $responseBody = $this->fetchResponse($url, $repositoryName);

        return count($responseBody);
    }

    private function getLatestRelease(string $baseUrl, string $repositoryName): string
    {
        $url = $baseUrl . '/releases/latest';

        $responseBody = $this->fetchResponse($url, $repositoryName);

        return $responseBody->published_at;
    }

    private function fetchResponse(string $url, string $repositoryName)
    {
        try {
            $response = $this->httpClient->request('GET', $url);
        } catch (GuzzleException $exception) {
            $this->handleException($exception, $repositoryName);
        }

        return json_decode($response->getBody()->getContents());
    }

    private function handleException(GuzzleException $exception, string $repositoryName): void
    {
        $exceptionCode = $exception->getCode();

        if ($exceptionCode === 404) {
            throw new RepositoryNotFoundException(sprintf('Repository %s was not found', $repositoryName));
        }

        throw new ApplicationException(sprintf(
            'Application is not available. %s. Repository %s can not be fetched',
            $exception->getMessage(),
            $repositoryName
        ));
    }
}
