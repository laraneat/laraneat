<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group authorization
 * @group api
 */
class ViewPermissionTest extends ApiTestCase
{
    protected string $url = 'v1/permissions/{id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testViewPermission(): void
    {
        $this->getTestingUser();

        $permission = Permission::factory()->create();
        $url = $this->buildApiUrl(
            replaces: ['{id}' => $permission->getKey()]
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->where('id', $permission->getKey())
                            ->where('name', $permission->name)
                            ->etc()
                    )
            );
    }
}
