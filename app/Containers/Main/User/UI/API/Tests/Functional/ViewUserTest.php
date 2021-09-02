<?php

namespace App\Containers\Main\User\UI\API\Tests\Functional;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\ApiTestCase;

/**
 * Class ViewUsersTest.
 *
 * @group user
 * @group api
 */
class ViewUserTest extends ApiTestCase
{
    protected string $url = 'get@api/v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'view-users',
    ];

    public function testViewExistingUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $response = $this->injectId($user->id)->makeCall();

        $response->assertStatus(200);
        $responseContent = $this->getResponseContentObject();
        $this->assertEquals($user->name, $responseContent->data->name);
    }

    public function testViewAnotherExistingUser(): void
    {
        $anotherUser = User::factory()->create();

        $response = $this->injectId($anotherUser->id)->makeCall();

        $response->assertStatus(200);
        $responseContent = $this->getResponseContentObject();
        $this->assertEquals($anotherUser->name, $responseContent->data->name);
    }

    public function testViewAnotherExistingUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();
        $anotherUser = User::factory()->create();

        $response = $this->injectId($anotherUser->id)->makeCall();

        $response->assertStatus(403);
    }

    public function testViewAnotherNotExistingUser(): void
    {
        $fakeUserId = 7777;

        $response = $this->injectId($fakeUserId)->makeCall();

        $response->assertStatus(404);
    }

    public function testViewFilteredUserResponse(): void
    {
        $user = $this->getTestingUser();

        $response = $this->injectId($user->id)->endpoint($this->endpoint . '?filter=email;name')->makeCall();

        $response->assertStatus(200);
        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($user->name, $responseContent->data->name);
        $this->assertEquals($user->email, $responseContent->data->email);
        $this->assertNotContains('id', json_decode($response->getContent(), true));
    }

//    public function testViewUserWithRelation(): void
//    {
//        $user = $this->getTestingUser();
//
//        $response = $this->injectId($user->id)->endpoint($this->endpoint . '?include=roles')->makeCall();
//
//        $response->assertStatus(200);
//        $responseContent = $this->getResponseContentObject();
//
//        $this->assertEquals($user->email, $responseContent->data->email);
//        $this->assertNotNull($responseContent->data->roles);
//    }
}
