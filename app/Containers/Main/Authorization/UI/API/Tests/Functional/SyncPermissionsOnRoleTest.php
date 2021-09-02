<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class SyncPermissionsOnRoleTest.
 *
 * @group authorization
 * @group api
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class SyncPermissionsOnRoleTest extends ApiTestCase
{
    protected string $url = 'v1/permissions/sync';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles',
    ];

    public function testSyncPermissionsOnRole(): void
    {
        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();
        $roleA = Role::factory()->create();
        $roleA->givePermissionTo($permissionA);
        $data = [
            'role_id' => $roleA->getKey(),
            'permissions_ids' => [$permissionA->getKey(), $permissionB->getKey()]
        ];

        $this->getTestingUser();
        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertOk()
                ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $roleA->id)
                            ->etc()
                    )
                );

        $this->assertTrue(
            Role::find($data['role_id'])
                ->permissions()
                ->pluck('id')
                ->diff($data['permissions_ids'])
                ->isEmpty()
        );
    }
}
