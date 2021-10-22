<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Role;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class AttachRolesToUserTest extends TestCase
{
    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testAttachRolesToUser(): void
    {
        $this->getTestingUser();

        $user = User::factory()->create();
        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();

        $url = route('api.users.roles.attach', ['user' => $user->getKey()]);
        $data = [
            'role_ids' => [$roleA->getKey(), $roleB->getKey()],
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

        $user = User::query()->first();

        $url = route('api.users.roles.attach', ['user' => $user->getKey()]);
        $data = [
            'role_ids' => ['bar', 'baz']
        ];

        $this->postJson($url, $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'role_ids.0',
                'role_ids.1'
            ]);
    }
}
