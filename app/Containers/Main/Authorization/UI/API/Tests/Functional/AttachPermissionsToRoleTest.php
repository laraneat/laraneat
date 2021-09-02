<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class AttachPermissionsToRoleTest.
 *
 * @group authorization
 * @group api
 */
class AttachPermissionsToRoleTest extends ApiTestCase
{
    protected string $url = 'v1/permissions/attach';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles',
    ];

    public function testAttachPermissionsToRole(): void
    {
        $roleA = Role::factory()->create();
        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();
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
                ->every(fn($item) => in_array($item, $data['permissions_ids'], true))
        );
    }
}
