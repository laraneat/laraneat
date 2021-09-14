<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;

/**
 * @group authorization
 * @group api
 */
class AttachRolesToUserTest extends ApiTestCase
{
    protected string $url = 'v1/users/{id}/roles/attach';

    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testAttachRolesToUser(): void
    {
        $this->getTestingUser();

        $user = User::factory()->create()->first();
        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();

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
                ->whereIn('id', $data['role_ids'])
                ->exists()
        );
    }

    public function testAttachRolesToUserWithWrongData(): void
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
