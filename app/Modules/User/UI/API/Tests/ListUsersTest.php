<?php

namespace App\Modules\User\UI\API\Tests;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group user
 * @group api
 */
class ListUsersTest extends TestCase
{
    protected string $url = 'api/v1/users';

    protected array $access = [
        'roles' => '',
        'permissions' => 'view-users',
    ];

    public function testListUsers(): void
    {
        $this->getTestingUser();

        User::factory()->count(2)->create();

        $this->getJson($this->buildUrl())
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
                'links',
                'meta',
                'data'
            ])
            ->assertJsonCount(User::query()->count(), 'data');
    }

    public function testListUsersWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();

        User::factory()->count(2)->create();

        $this->getJson($this->buildUrl())
            ->assertForbidden();
    }
}
