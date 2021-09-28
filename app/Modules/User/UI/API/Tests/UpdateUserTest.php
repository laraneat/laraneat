<?php

namespace App\Modules\User\UI\API\Tests;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group user
 * @group api
 */
class UpdateUserTest extends TestCase
{
    protected string $url = 'api/v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateCurrentUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $url = $this->buildUrl(
            replaces: ['{id}' => $user->getKey()]
        );
        $data = [
            'name' => 'Updated Name',
            'password' => 'updated#Password'
        ];
        $dataWithoutPassword = Arr::except($data, ['password']);

        $this->patchJson($url, $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('_profiler')
                ->has('data', fn (AssertableJson $json) =>
                $json->has('id')
                    ->whereAll($dataWithoutPassword)
                    ->etc()
                )
            );

        $this->assertExistsModelWithAttributes(User::class, $dataWithoutPassword);
    }

    public function testUpdateCurrentUserWithoutData(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $url = $this->buildUrl(
            replaces: ['{id}' => $user->getKey()]
        );

        $this->patchJson($url)
            ->assertStatus(417);
    }

    public function testUpdateCurrentUserWithEmptyValues(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $url = $this->buildUrl(
            replaces: ['{id}' => $user->getKey()]
        );
        $data = [
            'name' => '',
            'password' => ''
        ];

        $this->patchJson($url, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                // messages should be updated after modifying the validation rules, to pass this test
                'password' => 'The password must be at least 6 characters.',
                'name' => 'The name must be at least 2 characters.'
            ]);
    }

    public function testUpdateNonExistingUser(): void
    {
        $this->getTestingUser();

        $fakeUserId = 7777;
        $url = $this->buildUrl(
            replaces: ['{id}' => $fakeUserId]
        );
        $data = [
            'name' => 'Updated Name',
        ];

        $this->patchJson($url, $data)
            ->assertStatus(404);
    }

    public function testUpdateAnotherUser(): void
    {
        $this->getTestingUser();

        $anotherUser = User::factory()->create();

        $url = $this->buildUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );
        $data = [
            'name' => 'Updated Name',
            'password' => 'updated#Password'
        ];
        $expectedData = [
            'id' => $anotherUser->getKey(),
            'name' => $data['name']
        ];

        $this->patchJson($url, $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('_profiler')
                ->has('data', fn (AssertableJson $json) =>
                $json->whereAll($expectedData)
                    ->etc()
                )
            );

        $this->assertExistsModelWithAttributes(User::class, $expectedData);
    }

    public function testUpdateAnotherUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();

        $url = $this->buildUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );
        $data = [
            'name' => 'Updated Name',
            'password' => 'updated#Password'
        ];

        $this->patchJson($url, $data)
            ->assertStatus(403);
    }
}
