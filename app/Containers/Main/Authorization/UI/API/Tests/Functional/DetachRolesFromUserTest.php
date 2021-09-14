<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;

/**
 * @group authorization
 * @group api
 */
class DetachRolesFromUserTest extends ApiTestCase
{
    protected string $url = 'v1/users/{id}/roles/detach';

    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testDetachRolesFromUser(): void
    {
        $this->getTestingUser();

        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();
        $user = User::factory()->create();
        $user->assignRole($roleA, $roleB);

        $url = $this->buildApiUrl(replaces: ['{id}' => $user->getKey()]);
        $data = [
            'role_ids' => [$roleA->getKey(), $roleB->getKey()],
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertFalse(
            User::find($user->getKey())
                ->roles()
                ->whereIn('id', $data['role_ids'])
                ->exists()
        );
    }

    public function testDetachRolesFromUserWithWrongData(): void
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
