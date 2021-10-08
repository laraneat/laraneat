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
class ListRolePermissionsTest extends TestCase
{
    protected string $url = 'api/v1/roles/{id}/permissions';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testListRolePermissions(): void
    {
        $this->getTestingUser();

        $role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();

        $url = $this->buildUrl(
            replaces: ['{id}' => $role->id],
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJsonStructure([
                'links',
                'meta',
                'data'
            ])
            ->assertJsonCount(
                count_on_page(1, $role->permissions()->count()),
                'data'
            );
    }

    public function testListRolePermissionsWithParameters(): void
    {
        $this->getTestingUser();

        $role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();
        $permission = $role->permissions[0];

        $url = $this->buildUrl(
            queryParameters: [
                'filter' => [
                    'name' => $permission->name,
                ],
                'fields' => [
                    'permissions' => 'id,name,display_name',
                ],
            ],
            replaces: ['{id}' => $role->id],
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('links')
                    ->has('meta')
                    ->has('data', 1)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $permission->id)
                            ->where('name',$permission->name)
                            ->where('display_name',$permission->display_name)
                    )
            );
    }
}
