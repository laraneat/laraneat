<?php

namespace App\Containers\Main\User\UI\API\Tests\Functional;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\ApiTestCase;

/**
 * Class DeleteUserTest.
 *
 * @group user
 * @group api
 */
class DeleteUserTest extends ApiTestCase
{
    protected string $url = 'v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'delete-users',
    ];

    public function testDeleteCurrentUser(): void
    {
        $user = $this->getTestingUser();

        $url = $this->buildApiUrl(
            replaces: ['{id}' => $user->getKey()]
        );

        $this->deleteJson($url)->assertNoContent();

        $this->assertNull(User::find($user->getKey()));
    }

    public function testDeleteAnotherUser(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();

        $url = $this->buildApiUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );
        $this->deleteJson($url)->assertForbidden();
    }

    public function testDeleteNotExistingUser(): void
    {
        $this->getTestingUser();

        $url = $this->buildApiUrl(
            replaces: ['{id}' => '12345']
        );

        $this->deleteJson($url)
            ->assertNotFound();
    }
}
