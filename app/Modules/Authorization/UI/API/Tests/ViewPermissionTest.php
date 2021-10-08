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
class ViewPermissionTest extends TestCase
{
    protected string $url = 'api/v1/permissions/{id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testViewPermission(): void
    {
        $this->getTestingUser();

        $permission = Permission::factory()
            ->has(Role::factory()->count(3))
            ->create();

        $url = $this->buildUrl(
            queryParameters: [
                'fields' => [
                    'permissions' => 'id,name',
                    'roles' => 'id,display_name,name'
                ],
                'include' => 'roles'
            ],
            replaces: ['{id}' => $permission->getKey()],
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $permission->getKey())
                            ->where('name', $permission->name)
                            ->has('roles', $permission->roles()->count())
                            ->has('roles.0', fn (AssertableJson $json) =>
                                $json->has('id')
                                    ->has('display_name')
                                    ->has('name')
                                    ->has('pivot')
                            )
                    )
            );
    }
}
