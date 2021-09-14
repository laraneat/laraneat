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
class ViewRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles/{id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testViewRole(): void
    {
        $this->getTestingUser();

        $role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();

        $url = $this->buildApiUrl(
            queryParameters: [
                'fields' => [
                    'roles' => 'id,name',
                    'permissions' => 'id,display_name,group'
                ],
                'include' => 'permissions'
            ],
            replaces: ['{id}' => $role->getKey()],
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $role->getKey())
                            ->where('name', $role->name)
                            ->has('permissions', $role->permissions()->count())
                            ->has('permissions.0', fn (AssertableJson $json) =>
                                $json->has('id')
                                    ->has('display_name')
                                    ->has('group')
                                    ->has('pivot')
                            )
                    )
            );
    }
}
