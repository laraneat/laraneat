<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ListRolesTest extends TestCase
{
    protected string $url = 'api/v1/roles';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testListRoles(): void
    {
        $this->getTestingUser();

        $this->getJson($this->buildUrl())
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
                'links',
                'meta',
                'data'
            ])
            ->assertJsonCount(
                count_on_page(1, Role::query()->count()),
                'data'
            );
    }

    public function testListRolesWithParameters(): void
    {
        $this->getTestingUser();

        $role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();

        $url = $this->buildUrl(
            queryParameters: [
                'filter' => [
                    'name' => $role->name,
                ],
                'fields' => [
                    'roles' => 'id,name',
                    'permissions' => 'id,name,group',
                ],
                'include' => 'permissions'
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
                        $json->where('id', $role->id)
                            ->where('name',$role->name)
                            ->has('permissions', $role->permissions()->count())
                            ->has('permissions.0',fn (AssertableJson $json) =>
                                $json->has('id')
                                    ->has('name')
                                    ->has('group')
                                    ->has('pivot')
                            )

                    )
            );
    }
}
