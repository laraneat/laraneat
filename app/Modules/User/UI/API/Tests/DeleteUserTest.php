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
    protected array $access = [
        'roles' => '',
        'permissions' => 'delete-users',
    ];

    public function testDeleteCurrentUser(): void
    {
        $user = $this->getTestingUser();

        $this->deleteJson(route('api.users.delete', ['user' => $user->getKey()]))
            ->assertNoContent();

        $this->assertNull(User::find($user->getKey()));
    }

    public function testDeleteAnotherUser(): void
    {
        $this->getTestingUserWithoutAccess();

        $anotherUser = User::factory()->create();

        $this->deleteJson(route('api.users.delete', ['user' => $anotherUser->getKey()]))
            ->assertForbidden();
    }

    public function testDeleteNotExistingUser(): void
    {
        $this->getTestingUser();

        $this->deleteJson(route('api.users.delete', ['user' => 12345]))
            ->assertNotFound();
    }
}
