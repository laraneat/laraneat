<?php

namespace App\Containers\Main\User\UI\API\Tests\Functional;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\ApiTestCase;

/**
 * Class UpdateUserTest.
 *
 * @group user
 * @group api
 */
class UpdateUserTest extends ApiTestCase
{
    protected string $url = 'patch@api/v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateExistingUser(): void
    {
        $user = $this->getTestingUserWithoutAccess();
        $data = [
            'name' => 'Updated Name',
            'password' => 'updated#Password'
        ];

        $response = $this->injectId($user->id)->makeCall($data);

        $response->assertStatus(200);
        $this->assertResponseContainKeyValue([
            'email' => $user->email,
            'name' => $data['name']
        ]);
        $this->assertDatabaseHas('users', ['name' => $data['name']]);
    }

    public function testUpdateExistingUserWithoutData(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $response = $this->injectId($user->id)->makeCall();

        $response->assertStatus(417);
    }

    public function testUpdateExistingUserWithEmptyValues(): void
    {
        $user = $this->getTestingUserWithoutAccess();

        $data = [
            'name' => '',
            'password' => ''
        ];

        $response = $this->injectId($user->id)->makeCall($data);

        $response->assertStatus(422);
        $this->assertValidationErrorContain([
            // messages should be updated after modifying the validation rules, to pass this test
            'password' => 'The password must be at least 6 characters.',
            'name' => 'The name must be at least 2 characters.'
        ]);
    }

    public function testUpdateNonExistingUser(): void
    {
        $data = [
            'name' => 'Updated Name',
        ];
        $fakeUserId = 7777;

        $response = $this->injectId($fakeUserId)->makeCall($data);

        $response->assertStatus(404);
    }

    public function testUpdateAnotherUserWithAccess(): void
    {
        $anotherUser = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'password' => 'updated#Password'
        ];

        $response = $this->injectId($anotherUser->id)->makeCall($data);

        $response->assertStatus(200);
        $this->assertResponseContainKeyValue([
            'email' => $anotherUser->email,
            'name' => $data['name']
        ]);
        $this->assertDatabaseHas('users', ['name' => $data['name']]);
    }

    public function testUpdateAnotherUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'password' => 'updated#Password'
        ];

        $response = $this->injectId($anotherUser->id)->makeCall($data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['name' => $data['name']]);
    }
}
