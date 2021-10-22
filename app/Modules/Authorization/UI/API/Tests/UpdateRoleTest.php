<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class UpdateRoleTest extends TestCase
{
    /**
     * @var array{permissions: string|array<string>, roles:string|array<string>}
     */
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    protected Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        $this->role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();
    }

    public function testUpdateRole(): void
    {
        $this->getTestingUser();

        $newPermissions = Permission::factory()->count(3)->create();
        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things',
            'permission_ids' => $newPermissions->pluck('id')->toArray()
        ];

        $expectedData = Arr::except($data, ['permission_ids']);

        $this->postJson(route('api.roles.update', ['role' => $this->role->getKey()]), $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->has('id')
                        ->whereAll($expectedData)
                        ->etc()
                )
            );
        
        /** @var Role $role */
        $role = $this->makeQueryWhereColumns(Role::class, $expectedData)->first();
        $this->assertNotNull($role);
        $this->assertEqualsCanonicalizing($data['permission_ids'], $role->permissions->pluck('id')->toArray());
    }

    public function testUpdateRoleWithWrongName(): void
    {
        $newPermissions = Permission::factory()->count(3)->create();
        $data = [
            'name' => 'include Space',
            'display_name' => 'manager',
            'description' => 'he manages things',
            'permission_ids' => $newPermissions->pluck('id')->toArray()
        ];

        $this->getTestingUser();
        $this->postJson(route('api.roles.update', ['role' => $this->role->getKey()]), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
