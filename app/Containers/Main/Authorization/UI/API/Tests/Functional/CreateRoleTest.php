<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class CreateRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles';

    /**
     * @var array{permissions: string|array<string>, roles:string|array<string>}
     */
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testCreateRole(): void
    {
        $this->getTestingUser();

        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things',
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->has('id')
                            ->whereAll($data)
                            ->etc()
                        )
            );

        $this->assertExistsModelWithAttributes(Role::class, $data);
    }

    public function testCreateRoleWithWrongName(): void
    {
        $data = [
            'name' => 'include Space',
            'display_name' => 'manager',
            'description' => 'he manages things',
        ];

        $this->getTestingUser();
        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
