<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ListRolesTest extends ApiTestCase
{
    protected string $url = 'v1/roles';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    protected int $rolesCount;

    public function setUp(): void
    {
        parent::setUp();

        $this->rolesCount = Role::query()->count();
    }

    public function testListRoles(): void
    {
        $this->getTestingUser();

        $this->getJson($this->buildApiUrl())
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ])
            ->assertJsonCount(
                count_on_page(1, $this->rolesCount),
                'data'
            );
    }

    public function testListRolesWithParameters(): void
    {
        $this->getTestingUser();

        $role = Role::inRandomOrder()->first();
        $url = $this->buildApiUrl(
            queryParameters: [
                'filter' => [
                    'name' => $role->name,
                ],
                'fields' => [
                    'roles' => 'id,name',
                ],
                'include' => 'users'
            ]
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('_profiler')
                    ->has('current_page')
                    ->has('first_page_url')
                    ->has('from')
                    ->has('last_page')
                    ->has('last_page_url')
                    ->has('links')
                    ->has('next_page_url')
                    ->has('path')
                    ->has('per_page')
                    ->has('prev_page_url')
                    ->has('to')
                    ->has('total')
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $role->id)
                            ->where('name',$role->name)
                            ->has('users')
                            ->count('users', $role->users()->count())
                    )
            )
            ->assertJsonCount(
                1,
                'data'
            );
    }
}
