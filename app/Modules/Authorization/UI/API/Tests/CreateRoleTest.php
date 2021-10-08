<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class CreateRoleTest extends TestCase
{
    protected string $url = 'api/v1/roles';

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

        $this->postJson($this->buildUrl(), $data)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
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
        $this->postJson($this->buildUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
