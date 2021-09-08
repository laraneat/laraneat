<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class ViewRoleTest.
 *
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
        $role = Role::factory()->create();
        $url = $this->buildApiUrl(
            $this->url,
            [],
            ['{id}' => $role->getKey()]
        );

        $this->getTestingUser();
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
