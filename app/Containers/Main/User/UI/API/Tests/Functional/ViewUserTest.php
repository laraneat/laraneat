<?php

namespace App\Containers\Main\User\UI\API\Tests\Functional;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class ViewUsersTest.
 *
 * @group user
 * @group api
 */
class ViewUserTest extends ApiTestCase
{
    protected string $url = 'v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'view-users',
    ];

    public function testViewCurrentUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $url = $this->buildApiUrl(
            replaces: ['{id}' => $user->getKey()]
        );

        $expectedData = [
            'id' => $user->getKey(),
            'email' => $user->email,
        ];

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('_profiler')
                ->has('data', fn (AssertableJson $json) =>
                $json->whereAll($expectedData)
                    ->etc()
                )
            );
    }

    public function testViewAnotherUser(): void
    {
        $this->getTestingUser();

        $anotherUser = User::factory()->create();
        $url = $this->buildApiUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );
        $expectedData = [
            'id' => $anotherUser->getKey(),
            'email' => $anotherUser->email,
        ];

        $this->getJson($url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('_profiler')
                ->has('data', fn (AssertableJson $json) =>
                $json->whereAll($expectedData)
                    ->etc()
                )
            );
    }

    public function testViewAnotherUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();
        $url = $this->buildApiUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );

        $this->getJson($url)
            ->assertForbidden();
    }

    public function testViewAnotherNotExistingUser(): void
    {
        $this->getTestingUser();

        $fakeUserId = 7777;
        $url = $this->buildApiUrl(
            replaces: ['{id}' => $fakeUserId]
        );

        $this->getJson($url)
            ->assertNotFound();
    }
}
