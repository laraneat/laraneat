<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class SyncUserRolesTest extends ApiTestCase
{
    protected string $url = 'v1/roles/sync';

    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testSyncUserRoles(): void
    {
        $this->getTestingUser();

        $role1 = Role::factory()->create(['display_name' => '111']);
        $role2 = Role::factory()->create(['display_name' => '222']);
        $randomUser = User::factory()->create();
        $randomUser->assignRole($role1);
        $data = [
            'user_id' => $randomUser->getKey(),
            'role_ids' => [
                $role1->getKey(),
                $role2->getKey(),
            ],
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('_profiler')
                ->has('data', fn (AssertableJson $json) =>
                $json->where('id', $randomUser->id)
                    ->etc()
                )
            );

        $this->assertTrue(
            User::find($data['user_id'])
                ->roles()
                ->pluck('id')
                ->diff($data['role_ids'])
                ->isEmpty()
        );
    }

    public function testSyncUserRolesWithWrongData(): void
    {
        $this->getTestingUser();

        $data = [
            'user_id' => 'foo',
            'role_ids' => ['bar', 'baz']
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'user_id',
                'role_ids.0',
                'role_ids.1'
            ]);
    }
}
