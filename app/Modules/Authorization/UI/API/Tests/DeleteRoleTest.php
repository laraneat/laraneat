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
    protected string $url = 'api/v1/roles/{id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testDeleteRole(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();
        $url = $this->buildUrl(
            replaces: ['{id}' => $role->getKey()]
        );
        $this->deleteJson($url)->assertNoContent();

        $this->assertNull(Role::find($role->getKey()));
    }

    public function testDeleteNotExistingRole(): void
    {
        $this->getTestingUser();

        $url = $this->buildUrl(
            replaces: ['{id}' => '12345']
        );

        $this->deleteJson($url)
            ->assertNotFound();
    }
}
