<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ListUserRolesTest extends ApiTestCase
{
    protected string $url = 'v1/users/{id}/roles';

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

        $url = $this->buildApiUrl(
            replaces: ['{id}' => $user->id],
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
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

        $url = $this->buildApiUrl(
            queryParameters: [
                'filter' => [
                    'name' => $role->name,
                ],
                'fields' => [
                    'roles' => 'id,name,display_name',
                    'permissions' => 'id,name,group'
                ],
                'include' => 'permissions'
            ],
            replaces: ['{id}' => $user->id],
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
