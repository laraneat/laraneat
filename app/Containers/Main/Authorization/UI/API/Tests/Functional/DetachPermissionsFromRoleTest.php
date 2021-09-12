<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;

/**
 * @group authorization
 * @group api
 */
class DetachPermissionsFromRoleTest extends ApiTestCase
{
    protected string $url = 'v1/permissions/detach';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testDetachPermissionsFromRole(): void
    {
        $this->getTestingUser();

        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();
        $roleA = Role::factory()->create();
        $roleA->givePermissionTo($permissionA);
        $roleA->givePermissionTo($permissionB);
        $data = [
            'role_id' => $roleA->getKey(),
            'permissions_ids' => [$permissionA->getKey(), $permissionB->getKey()],
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertOk();

        $this->assertFalse(
            Role::find($data['role_id'])
                ->permissions()
                ->whereIn('id', $data['permissions_ids'])
                ->exists()
        );
    }
}
