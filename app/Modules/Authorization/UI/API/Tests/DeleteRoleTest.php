<?php

namespace App\Modules\Authorization\UI\API\Tests;

use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group api
 */
class DeleteRoleTest extends TestCase
{
    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testDeleteRole(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();
        $this->deleteJson(route('api.roles.delete', ['role' => $role->id]))
            ->assertNoContent();

        $this->assertNull(Role::find($role->getKey()));
    }

    public function testDeleteNotExistingRole(): void
    {
        $this->getTestingUser();

        $this->deleteJson(route('api.roles.delete', ['role' => 7777]))
            ->assertNotFound();
    }
}
