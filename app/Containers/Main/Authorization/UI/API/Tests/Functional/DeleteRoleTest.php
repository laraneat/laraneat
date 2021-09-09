<?php

namespace App\Containers\Main\Authorization\UI\API\Tests\Functional;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;

/**
 * Class DeleteRoleTest.
 *
 * @group authorization
 * @group api
 */
class DeleteRoleTest extends ApiTestCase
{
    protected string $url = 'v1/roles/{id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => '',
    ];

    public function testDeleteExistingRole(): void
    {
        $this->getTestingUser();

        $role = Role::factory()->create();
        $url = $this->buildApiUrl(
            replaces: ['{id}' => $role->getKey()]
        );
        $this->deleteJson($url)->assertNoContent();

        $this->assertNull(Role::find($role->getKey()));
    }

    public function testDeleteNotExistingRole(): void
    {
        $this->getTestingUser();

        $url = $this->buildApiUrl(
            replaces: ['{id}' => '12345']
        );

        $this->deleteJson($url)
            ->assertNotFound();
    }
}
