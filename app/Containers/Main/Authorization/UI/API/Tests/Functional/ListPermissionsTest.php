<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
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

    public function testListPermissions(): void
    {
        $this->getTestingUser();

        $this->getJson($this->buildApiUrl())
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
                'links',
                'meta',
                'data'
            ])
            ->assertJsonCount(
                count_on_page(1, Permission::query()->count()),
                'data'
            );
    }

    public function testListPermissionsWithParameters(): void
    {
        $this->getTestingUser();

        $permission = Permission::factory()
            ->has(Role::factory()->count(3))
            ->create();

        $url = $this->buildApiUrl(
            queryParameters: [
                'filter' => [
                    'name' => $permission->name,
                ],
                'fields' => [
                    'permissions' => 'id,name,display_name',
                    'roles' => 'id,name'
                ],
                'include' => 'roles'
            ]
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('_profiler')
                    ->has('links')
                    ->has('meta')
                    ->has('data', 1)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $permission->id)
                            ->where('name',$permission->name)
                            ->where('display_name',$permission->display_name)
                            ->has('roles',  $permission->roles()->count())
                            ->has('roles.0', fn (AssertableJson $json) =>
                                $json->has('id')
                                    ->has('name')
                                    ->has('pivot')
                            )
                    )
            );
    }
}
