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
class ListPermissionsTest extends TestCase
{
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testListPermissions(): void
    {
        $this->getTestingUser();

        $this->getJson(route('api.permissions.list'))
            ->assertOk()
            ->assertJsonStructure([
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

        $url = route('api.permissions.list', [
            'filter' => [
                'name' => $permission->name,
            ],
            'fields' => [
                'permissions' => 'id,name,display_name',
                'roles' => 'id,name'
            ],
            'include' => 'roles'
        ]);

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('links')
                    ->has('meta')
                    ->has('data', 1)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $permission->getKey())
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
