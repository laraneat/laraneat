<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Role;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class DetachRolesFromUserTest extends TestCase
{
    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testDetachRolesFromUser(): void
    {
        $this->getTestingUser();

        $user = User::factory()
            ->has(Role::factory()->count(3))
            ->create();
        $roleIds = $user->roles()->pluck('id')->toArray();

        $url = route('api.users.roles.detach', ['user' => $user->getKey()]);
        $data = [
            'role_ids' => [$roleIds[0], $roleIds[2]],
        ];

        $this->postJson($url, $data)
            ->assertOk();

        $this->assertFalse(
            User::find($user->getKey())
                ->roles()
                ->whereIn('id', $data['role_ids'])
                ->exists()
        );

        $this->assertTrue(
            User::find($user->getKey())
                ->roles()
                ->where('id', $roleIds[1])
                ->exists()
        );
    }

    public function testDetachRolesFromUserWithWrongData(): void
    {
        $this->getTestingUser();

        $user = User::query()->first();

        $url = route('api.users.roles.detach', ['user' => $user->getKey()]);
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
