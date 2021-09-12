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
    protected string $url = 'v1/roles/detach';

    protected array $access = [
        'permissions' => 'attach-roles',
        'roles' => '',
    ];

    public function testDetachRolesFromUser(): void
    {
        $this->getTestingUser();

        $randomUser = User::factory()->create();
        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();
        $randomUser->assignRole($roleA);
        $randomUser->assignRole($roleB);

        $data = [
            'role_ids' => [$roleA->getKey(), $roleB->getKey()],
            'user_id' => $randomUser->getKey(),
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertOk();

        $this->assertFalse(
            User::find($data['user_id'])
                ->roles()
                ->whereIn('id', $data['role_ids'])
                ->exists()
        );
    }
}
