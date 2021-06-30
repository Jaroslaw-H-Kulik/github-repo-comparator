<?php

declare(strict_types=1);

namespace App\Tests\api;

use App\Tests\ApiTester;

class CompareRepositoriesCest
{
    public function testIntegration(ApiTester $I)
    {
        $requestBody = json_encode([
            (object)[
                'repositoryName' => 'Skeleton',
                'repositoryOwner' => 'Symfony'
            ],
            (object)[
                'repositoryName' => 'Codeception',
                'repositoryOwner' => 'Codeception'
            ]
        ]);

        $I->sendPost('/repositories/compare', $requestBody);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
