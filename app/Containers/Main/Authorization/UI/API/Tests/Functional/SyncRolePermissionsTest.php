<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;

/**
 * @group authorization
 * @group api
 */
class SyncRolePermissionsTest extends ApiTestCase
{
    protected string $url = 'v1/roles/{id}/permissions/sync';

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

        $url = $this->buildApiUrl(replaces: ['{id}' => $role->getKey()]);
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

        $url = $this->buildApiUrl(replaces: ['{id}' => 1]);
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
