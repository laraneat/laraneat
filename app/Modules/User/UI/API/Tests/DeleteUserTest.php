<?php

namespace App\Modules\User\UI\API\Tests;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group user
 * @group api
 */
class DeleteUserTest extends TestCase
{
    protected string $url = 'api/v1/users/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'delete-users',
    ];

    public function testDeleteCurrentUser(): void
    {
        $user = $this->getTestingUser();

        $url = $this->buildUrl(
            replaces: ['{id}' => $user->getKey()]
        );

        $this->deleteJson($url)->assertNoContent();

        $this->assertNull(User::find($user->getKey()));
    }

    public function testDeleteAnotherUser(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();

        $url = $this->buildUrl(
            replaces: ['{id}' => $anotherUser->getKey()]
        );
        $this->deleteJson($url)->assertForbidden();
    }

    public function testDeleteNotExistingUser(): void
    {
        $this->getTestingUser();

        $url = $this->buildUrl(
            replaces: ['{id}' => '12345']
        );

        $this->deleteJson($url)
            ->assertNotFound();
    }
}
