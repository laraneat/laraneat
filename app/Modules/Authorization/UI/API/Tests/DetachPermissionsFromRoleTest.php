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

        $role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();

        $permissionIds = $role->permissions()->pluck('id')->toArray();

        $url = route('api.roles.permissions.detach', ['role' => $role->getKey()]);
        $data = [
            'permission_ids' => [$permissionIds[0], $permissionIds[2]],
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertFalse(
            Role::find($role->getKey())
                ->permissions()
                ->whereIn('id', $data['permission_ids'])
                ->exists()
        );

        $this->assertTrue(
            Role::find($role->getKey())
                ->permissions()
                ->where('id', $permissionIds[1])
                ->exists()
        );
    }

    public function testDetachPermissionsFromRolesWithWrongData(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();

        $url = route('api.roles.permissions.detach', ['role' => $role->getKey()]);
        $data = [
            'permission_ids' => ['bar', 'baz']
        ];

        $this->postJson($url, $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'permission_ids.0',
                'permission_ids.1'
            ]);
    }
}
