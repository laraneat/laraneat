<?php

namespace App\Modules\User\UI\API\Tests;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group user
 * @group api
 */
class ViewUserTest extends TestCase
{
    protected string $url = 'api/v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'view-users',
    ];

    public function testViewCurrentUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $url = $this->buildUrl(
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
        $url = $this->buildUrl(
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
        $url = $this->buildUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );

        $this->getJson($url)
            ->assertForbidden();
    }

    public function testViewAnotherNotExistingUser(): void
    {
        $this->getTestingUser();

        $fakeUserId = 7777;
        $url = $this->buildUrl(
            replaces: ['{id}' => $fakeUserId]
        );

        $this->getJson($url)
            ->assertNotFound();
    }
}
