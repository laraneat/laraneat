<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ViewRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles/{id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testFindRoleById(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();
        $url = $this->buildApiUrl(
            replaces: ['{id}' => $role->getKey()]
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $role->getKey())
                            ->where('name', $role->name)
                            ->etc()
                    )
            );
    }
}
