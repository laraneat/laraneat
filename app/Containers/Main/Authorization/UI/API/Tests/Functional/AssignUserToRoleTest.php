<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;

/**
 * Class AssignUserToRoleTest.
 *
 * @group authorization
 * @group api
 */
class AssignUserToRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles/assign';

    protected array $access = [
        'permissions' => 'assign-roles',
        'roles' => '',
    ];

    public function testAssignUserToRoles(): void
    {
        $this->getTestingUser();

        $randomUser = User::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();
        $data = [
            'role_ids' => [
                $role1->getKey(),
                $role2->getKey(),
            ],
            'user_id' => $randomUser->getKey(),
        ];

        $response = $this->postJson($this->buildApiUrl(), $data)
            ->assertOk()
            ->assertJsonStructure(['_profiler', 'data']);

        $this->assertTrue(
            collect($response->json('data.roles'))
                ->pluck('id')
                ->every(fn($item) => in_array($item, $data['role_ids'], true))
        );

        $this->assertTrue(
            User::find($data['user_id'])
                ->roles()
                ->pluck('id')
                ->every(fn($item) => in_array($item, $data['role_ids'], true))
        );
    }
}
