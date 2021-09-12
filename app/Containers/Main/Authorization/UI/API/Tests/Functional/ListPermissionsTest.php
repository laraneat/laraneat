<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ListPermissionsTest extends ApiTestCase
{
    protected string $url = 'v1/permissions';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    protected int $permissionsCount;

    public function setUp(): void
    {
        parent::setUp();

        $this->permissionsCount = Permission::query()->count();
    }

    public function testListPermissions(): void
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
                count_on_page(1, $this->permissionsCount),
                'data'
            );
    }

    public function testListPermissionsWithParameters(): void
    {
        $this->getTestingUser();

        $permission = Permission::inRandomOrder()->first();
        $url = $this->buildApiUrl(
            queryParameters: [
                'filter' => [
                    'name' => $permission->name,
                ],
                'fields' => [
                    'permissions' => 'id,name',
                ],
                'include' => 'roles'
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
                        $json->where('id', $permission->id)
                            ->where('name',$permission->name)
                            ->has('roles')
                            ->count('roles', $permission->roles()->count())
                    )
            )
            ->assertJsonCount(
                1,
                'data'
            );
    }
}
