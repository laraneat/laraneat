<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;

/**
 * Class RevokeUserFromRoleTest.
 *
 * @group authorization
 * @group api
 */
class RevokeUserFromRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles/revoke';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testRevokeUserFromRoles(): void
    {
        $randomUser = User::factory()->create();
        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();
        $randomUser->assignRole($roleA);
        $randomUser->assignRole($roleB);

        $data = [
            'role_ids' => [$roleA->getKey(), $roleB->getKey()],
            'user_id' => $randomUser->getKey(),
        ];

        $this->getTestingUser();
        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertOk();

        $this->assertFalse(
            User::find($data['user_id'])
                ->roles()
                ->whereIn('id', $data['role_ids'])
                ->exists()
        );
    }
}
