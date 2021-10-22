<?php

namespace App\Modules\Authorization\Tests\Feature\Actions;

use App\Modules\Authorization\Actions\CreatePermissionAction;
use App\Modules\Authorization\DTO\CreatePermissionDTO;
use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group feature
 */
class CreatePermissionActionTest extends TestCase
{
    public function testCreatePermission(): void
    {
        $data = [
            'name' => 'some-permission',
            'description' => 'Some permission for testing',
            'display_name' => 'Some permission',
            'group' => 'testing',
            'guard_name' => 'api',
        ];

        CreatePermissionAction::make()->handle(new CreatePermissionDTO($data));

        $this->assertExistsModelWhereColumns(Permission::class, $data);
    }
}
