<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Role;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class SyncUserRolesTest extends TestCase
{
    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testSyncUserRoles(): void
    {
        $this->getTestingUser();

        $roleA = Role::factory()->create(['display_name' => '111']);
        $roleB = Role::factory()->create(['display_name' => '222']);
        $user = User::factory()->create();
        $user->assignRole($roleA);

        $url = route('api.users.roles.sync', ['user' => $user->id]);
        $data = [
            'role_ids' => [
                $roleA->getKey(),
                $roleB->getKey(),
            ],
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertTrue(
            User::find($user->getKey())
                ->roles()
                ->pluck('id')
                ->diff($data['role_ids'])
                ->isEmpty()
        );
    }

    public function testSyncUserRolesWithWrongData(): void
    {
        $this->getTestingUser();

        $user = User::query()->first();

        $url = route('api.users.roles.sync', ['user' => $user->id]);
        $data = [
            'role_ids' => ['bar', 'baz']
        ];

        $this->postJson($url, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'role_ids.0',
                'role_ids.1'
            ]);
    }
}
