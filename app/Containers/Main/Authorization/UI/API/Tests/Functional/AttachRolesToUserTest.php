<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use App\Containers\Main\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class AttachRolesToUserTest extends ApiTestCase
{
    protected string $url = 'v1/roles/attach';

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
        $data = [
            'user_id' => $user->getKey(),
            'role_ids' => [
                $roleA->getKey(),
                $roleB->getKey(),
            ],
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $user->id)
                            ->etc()
                    )
            );
    }

    public function testAttachRolesToUserWithWrongData(): void
    {
        $this->getTestingUser();

        $data = [
            'user_id' => 'foo',
            'role_ids' => ['bar', 'baz']
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'user_id',
                'role_ids.0',
                'role_ids.1'
            ]);
    }
}
