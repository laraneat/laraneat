<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class CreateRoleTest.
 *
 * @group authorization
 * @group api
 */
class CreateRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles',
    ];

    public function testCreateRole(): void
    {
        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things',
        ];

        $this->getTestingUser();
        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->has('id')
                            ->whereAll($data)
                            ->etc()
                        )
            );

        $query = Role::query();
        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }
        $this->assertTrue($query->exists());
    }

    public function testCreateRoleWithWrongName(): void
    {
        $data = [
            'name' => 'include Space',
            'display_name' => 'manager',
            'description' => 'he manages things',
        ];

        $this->getTestingUser();
        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertStatus(422);
    }
}
