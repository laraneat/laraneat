<?php

namespace App\Modules\User\UI\API\Tests;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group user
 * @group api
 */
class UpdateUserTest extends TestCase
{
    protected array $access = [
        'roles' => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateCurrentUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();
        $data = [
            'name' => 'Updated Name',
        ];

        $this->patchJson(route('api.users.update', ['user' => $user->getKey()]), $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->has('id')
                        ->whereAll($data)
                        ->etc()
                    )
            );

        $this->assertExistsModelWhereColumns(User::class, $data);
    }

    public function testUpdateCurrentUserWithoutData(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $this->patchJson(route('api.users.update', ['user' => $user->getKey()]))
            ->assertStatus(417);
    }

    public function testUpdateCurrentUserWithEmptyValues(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $data = [
            'name' => '',
        ];

        $this->patchJson(route('api.users.update', ['user' => $user->getKey()]), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ]);
    }

    public function testUpdateNonExistingUser(): void
    {
        $this->getTestingUser();

        $data = [
            'name' => 'Updated Name',
        ];

        $this->patchJson(route('api.users.update', ['user' => 7777]), $data)
            ->assertStatus(404);
    }

    public function testUpdateAnotherUser(): void
    {
        $this->getTestingUser();

        $anotherUser = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
        ];
        $expectedData = [
            'id' => $anotherUser->getKey(),
            'name' => $data['name']
        ];

        $this->patchJson(route('api.users.update', ['user' => $anotherUser->getKey()]), $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->whereAll($expectedData)
                        ->etc()
                )
            );

        $this->assertExistsModelWhereColumns(User::class, $expectedData);
    }

    public function testUpdateAnotherUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
        ];

        $this->patchJson(route('api.users.update', ['user' => $anotherUser->getKey()]), $data)
            ->assertStatus(403);
    }
}
