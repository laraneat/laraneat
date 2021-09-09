<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class ListPermissionsTest.
 *
 * @group authorization
 * @group api
 */
class ListPermissionsTest extends ApiTestCase
{
    protected string $url = 'v1/permissions';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    protected int $permissionsCount;

    public function setUp(): void
    {
        parent::setUp();

        $this->permissionsCount = Permission::query()->count();
    }

    public function testListPermissions(): void
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
                $this->getCountOnPage(1, $this->permissionsCount),
                'data'
            );
    }

    public function testListPermissionsWithParameters(): void
    {
        $this->getTestingUser();

        $permission = Permission::inRandomOrder()->first();
        $url = $this->buildApiUrl(
            queryParameters: [
                'filter' => [
                    'name' => $permission->name,
                ],
                'fields' => [
                    'permissions' => 'id,name',
                ],
                'include' => 'roles'
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
                        $json->where('id', $permission->id)
                            ->where('name',$permission->name)
                            ->has('roles')
                            ->count('roles', $permission->roles()->count())
                    )
            )
            ->assertJsonCount(
                1,
                'data'
            );
    }
}
