<?php

namespace App\Modules\Authorization\Tests\Feature\Actions;

use App\Modules\Authorization\Actions\UpdatePermissionAction;
use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group feature
 */
class UpdatePermissionActionTest extends TestCase
{
    public function testUpdatePermission(): void
    {
        $permission = Permission::factory()->create();

        $data = [
            'name' => 'some-permission',
            'description' => 'Some permission for testing',
            'display_name' => 'Some permission',
            'group' => 'testing',
            'guard_name' => 'api',
        ];

        UpdatePermissionAction::make()->handle($permission, $data);

        $this->assertExistsModelWhereColumns(Permission::class, array_merge(
            $data,
            ['id' => $permission->getKey()]
        ));
    }
}
