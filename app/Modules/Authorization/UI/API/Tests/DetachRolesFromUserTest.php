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

        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();
        $user = User::factory()->create();
        $user->assignRole($roleA, $roleB);

        $url = route('api.users.roles.detach', ['user' => $user->id]);
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

        $user = User::query()->first();

        $url = route('api.users.roles.detach', ['user' => $user->id]);
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
