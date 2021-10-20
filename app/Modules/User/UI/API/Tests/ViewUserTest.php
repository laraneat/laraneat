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
    protected array $access = [
        'roles' => '',
        'permissions' => 'view-users',
    ];

    public function testViewCurrentUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $expectedData = [
            'id' => $user->getKey(),
            'email' => $user->email,
        ];

        $this->getJson(route('api.users.view', ['user' => $user->getKey()]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->whereAll($expectedData)
                        ->etc()
                )
            );
    }

    public function testViewAnotherUser(): void
    {
        $this->getTestingUser();

        $anotherUser = User::factory()->create();
        $expectedData = [
            'id' => $anotherUser->getKey(),
            'email' => $anotherUser->email,
        ];

        $this->getJson(route('api.users.view', ['user' => $anotherUser->getKey()]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->whereAll($expectedData)
                        ->etc()
                )
            );
    }

    public function testViewAnotherUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();

        $this->getJson(route('api.users.view', ['user' => $anotherUser->getKey()]))
            ->assertForbidden();
    }

    public function testViewAnotherNotExistingUser(): void
    {
        $this->getTestingUser();

        $this->getJson(route('api.users.view', ['user' => 7777]))
            ->assertNotFound();
    }
}
