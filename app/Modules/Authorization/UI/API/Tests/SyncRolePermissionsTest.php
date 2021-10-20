<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class SyncRolePermissionsTest extends TestCase
{
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testSyncRolePermissions(): void
    {
        $this->getTestingUser();

        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();

        $role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();
        $role->givePermissionTo($permissionA);

        $url = route('api.roles.permissions.sync', ['role' => $role->getKey()]);
        $data = [
            'permission_ids' => [$permissionA->getKey(), $permissionB->getKey()]
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertTrue(
            Role::find($role->getKey())
                ->permissions()
                ->pluck('id')
                ->diff($data['permission_ids'])
                ->isEmpty()
        );
    }

    public function testSyncRolePermissionsWithWrongData(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();

        $url = route('api.roles.permissions.sync', ['role' => $role->getKey()]);
        $data = [
            'permission_ids' => ['bar', 'baz']
        ];

        $this->postJson($url, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'permission_ids.0',
                'permission_ids.1'
            ]);
    }
}
