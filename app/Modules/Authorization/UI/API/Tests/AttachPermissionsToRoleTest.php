<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class AttachPermissionsToRoleTest extends TestCase
{
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testAttachPermissionsToRole(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create()->first();
        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();

        $url = route('api.roles.permissions.attach', ['role' => $role->id]);
        $data = [
            'permission_ids' => [$permissionA->getKey(), $permissionB->getKey()]
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertTrue(
            Role::find($role->getKey())
                ->permissions()
                ->whereIn('id', $data['permission_ids'])
                ->exists()
        );
    }

    public function testAttachPermissionsToRoleWithWrongData(): void
    {
        $this->getTestingUser();

        $role = Role::query()->first();
        
        $url = route('api.roles.permissions.attach', ['role' => $role->id]);
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
