<?php

namespace App\Containers\Main\User\UI\API\Tests\Functional;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\ApiTestCase;

/**
 * Class ListUsersTest.
 *
 * @group user
 * @group api
 */
class ListUsersTest extends ApiTestCase
{
    protected string $url = 'v1/users';

    protected array $access = [
        'roles' => '',
        'permissions' => 'view-users',
    ];

    public function testListUsersWithAccess(): void
    {
        User::factory()->count(2)->create();

        $this->getTestingUser();
        $this->getJson($this->buildApiUrl($this->url))
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
                'data',
            ])
            ->assertJsonCount(User::query()->count(), 'data');
    }

    public function testListUsersWithoutAccess(): void
    {
        User::factory()->count(2)->create();

        $this->getTestingUserWithoutAccess();
        $this->getJson($this->buildApiUrl($this->url))
            ->assertForbidden();
    }
}
