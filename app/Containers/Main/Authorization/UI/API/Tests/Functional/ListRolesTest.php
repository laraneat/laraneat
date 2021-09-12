<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ListRolesTest extends ApiTestCase
{
    protected string $url = 'v1/roles';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    protected int $rolesCount;

    public function setUp(): void
    {
        parent::setUp();

        $this->rolesCount = Role::query()->count();
    }

    public function testListRoles(): void
    {
        $this->getTestingUser();

        $this->getJson($this->buildApiUrl())
            ->assertOk()
            ->assertJsonStructure([
                '_profiler',
                'links',
                'meta',
                'data'
            ])
            ->assertJsonCount(
                count_on_page(1, $this->rolesCount),
                'data'
            );
    }

    public function testListRolesWithParameters(): void
    {
        $this->getTestingUser();

        $role = Role::inRandomOrder()->first();
        $url = $this->buildApiUrl(
            queryParameters: [
                'filter' => [
                    'name' => $role->name,
                ],
                'fields' => [
                    'roles' => 'id,name',
                ],
                'include' => 'users'
            ]
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('_profiler')
                    ->has('links')
                    ->has('meta')
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $role->id)
                            ->where('name',$role->name)
                            ->has('users')
                            ->count('users', $role->users()->count())
                    )
            )
            ->assertJsonCount(
                1,
                'data'
            );
    }
}
