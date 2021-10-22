<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class CreateRoleTest extends TestCase
{
    /**
     * @var array{permissions: string|array<string>, roles:string|array<string>}
     */
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    protected Collection $permissions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->permissions = Permission::factory()->count(3)->create();
    }

    public function testCreateRole(): void
    {
        $this->getTestingUser();

        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things',
            'permission_ids' => $this->permissions->pluck('id')->toArray()
        ];

        $expectedData = Arr::except($data, ['permission_ids']);

        $this->postJson(route('api.roles.create'), $data)
            ->assertCreated()
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

    public function testCreateRoleWithWrongName(): void
    {
        $data = [
            'name' => 'include Space',
            'display_name' => 'manager',
            'description' => 'he manages things',
            'permission_ids' => $this->permissions->pluck('id')->toArray()
        ];

        $this->getTestingUser();
        $this->postJson(route('api.roles.create'), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
