<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class AttachPermissionsToRoleTest extends ApiTestCase
{
    protected string $url = 'v1/permissions/attach';

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
        $data = [
            'role_id' => $role->getKey(),
            'permissions_ids' => [$permissionA->getKey(), $permissionB->getKey()]
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $role->id)
                            ->etc()
                    )
            );
    }

    public function testAttachPermissionsToRoleWithWrongData(): void
    {
        $this->getTestingUser();

        $data = [
            'role_id' => 'foo',
            'permissions_ids' => ['bar', 'baz']
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'role_id',
                'permissions_ids.0',
                'permissions_ids.1'
            ]);
    }
}
