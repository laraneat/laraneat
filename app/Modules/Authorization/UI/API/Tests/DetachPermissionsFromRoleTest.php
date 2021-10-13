<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class DetachPermissionsFromRoleTest extends TestCase
{
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testDetachPermissionsFromRole(): void
    {
        $this->getTestingUser();

        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();
        $role = Role::factory()->create();
        $role->givePermissionTo($permissionA, $permissionB);

        $url = route('api.roles.permissions.detach', ['role' => $role->id]);
        $data = [
            'permission_ids' => [$permissionA->getKey(), $permissionB->getKey()],
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertFalse(
            Role::find($role->getKey())
                ->permissions()
                ->whereIn('id', $data['permission_ids'])
                ->exists()
        );
    }

    public function testDetachPermissionsFromRolesWithWrongData(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();

        $url = route('api.roles.permissions.detach', ['role' => $role->id]);
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
