<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ListUserRolesTest extends TestCase
{
    protected array $access = [
        'permissions' => 'manage-roles',
        'users' => '',
    ];

    public function testListUserRoles(): void
    {
        $this->getTestingUser();

        $user = User::factory()
            ->has(Role::factory()->count(3))
            ->create();

        $this->getJson(route('api.users.roles.list', ['user' => $user->getKey()]))
            ->assertOk()
            ->assertJsonStructure([
                'links',
                'meta',
                'data'
            ])
            ->assertJsonCount(
                count_on_page(1, $user->roles()->count()),
                'data'
            );
    }

    public function testListUserRolesWithParameters(): void
    {
        $this->getTestingUser();

        $user = User::factory()
            ->has(
                Role::factory()
                    ->has(Permission::factory()->count(3))
                    ->count(3))
            ->create();
        $role = $user->roles[0];

        $url = route('api.users.roles.list', [
            'user' => $user->getKey(),
            'filter' => [
                'name' => $role->name,
            ],
            'fields' => [
                'roles' => 'id,name,display_name',
                'permissions' => 'id,name,group'
            ],
            'include' => 'permissions'

        ]);

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('links')
                    ->has('meta')
                    ->has('data', 1)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $role->getKey())
                            ->where('name',$role->name)
                            ->where('display_name',$role->display_name)
                            ->has('permissions', $role->permissions()->count())
                            ->has('permissions.0', fn (AssertableJson $json) =>
                                $json->has('id')
                                    ->has('name')
                                    ->has('group')
                                    ->has('pivot')
                            )
                    )
            );
    }
}
