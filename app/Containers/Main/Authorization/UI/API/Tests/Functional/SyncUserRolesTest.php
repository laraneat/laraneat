<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;

/**
 * @group authorization
 * @group api
 */
class SyncUserRolesTest extends ApiTestCase
{
    protected string $url = 'v1/users/{id}/roles/sync';

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

        $url = $this->buildApiUrl(replaces: ['{id}' => $user->getKey()]);
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

        $url = $this->buildApiUrl(replaces: ['{id}' => 1]);
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
