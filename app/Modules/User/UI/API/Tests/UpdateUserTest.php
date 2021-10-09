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
        ];

        $this->patchJson($url, $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->has('id')
                        ->whereAll($data)
                        ->etc()
                    )
            );

        $this->assertExistsModelWithAttributes(User::class, $data);
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
        ];

        $this->patchJson($url, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
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
        ];
        $expectedData = [
            'id' => $anotherUser->getKey(),
            'name' => $data['name']
        ];

        $this->patchJson($url, $data)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
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
        ];

        $this->patchJson($url, $data)
            ->assertStatus(403);
    }
}
