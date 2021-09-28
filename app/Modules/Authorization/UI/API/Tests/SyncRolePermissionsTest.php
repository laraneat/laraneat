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
    protected string $url = 'api/v1/roles/{id}/permissions/sync';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testSyncRolePermissions(): void
    {
        $this->getTestingUser();

        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();
        $role = Role::factory()->create();
        $role->givePermissionTo($permissionA);

        $url = $this->buildUrl(replaces: ['{id}' => $role->getKey()]);
        $data = [
            'permissions_ids' => [$permissionA->getKey(), $permissionB->getKey()]
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertTrue(
            Role::find($role->getKey())
                ->permissions()
                ->pluck('id')
                ->diff($data['permissions_ids'])
                ->isEmpty()
        );
    }

    public function testSyncRolePermissionsWithWrongData(): void
    {
        $this->getTestingUser();

        $url = $this->buildUrl(replaces: ['{id}' => 1]);
        $data = [
            'permissions_ids' => ['bar', 'baz']
        ];

        $this->postJson($url, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'permissions_ids.0',
                'permissions_ids.1'
            ]);
    }
}