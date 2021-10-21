<?php

namespace App\Modules\Authorization\Tests\Feature\Actions;

use App\Modules\Authorization\Actions\DetachPermissionsFromRoleAction;
use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group feature
 */
class DetachPermissionsFromRoleActionTest extends TestCase
{
    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpData();
    }

    protected function setUpData(): void
    {
        $this->role = Role::factory()
            ->has(Permission::factory()->count(3))
            ->create();
    }

    public function testDetachPermissionIdsFromRole(): void
    {
        $permissionIds = $this->role->permissions()->pluck('id')->toArray();
        $permissionIdsToDetach = [$permissionIds[0], $permissionIds[2]];

        DetachPermissionsFromRoleAction::make()->handle($this->role, $permissionIdsToDetach);

        $this->assertEqualsCanonicalizing(
            [$permissionIds[1]],
            Role::find($this->role->getKey())
                ->permissions()
                ->pluck('id')
                ->toArray()
        );
    }

    public function testDetachPermissionNamesFromRole(): void
    {
        $permissions = $this->role->permissions()->get();
        $permissionNamesToDetach = [$permissions[0]->name, $permissions[2]->name];
        DetachPermissionsFromRoleAction::make()->handle($this->role, $permissionNamesToDetach);

        $this->assertEqualsCanonicalizing(
            [$permissions[1]->getKey()],
            Role::find($this->role->getKey())
                ->permissions()
                ->pluck('id')
                ->toArray()
        );
    }

    public function testDetachPermissionModelsFromRole(): void
    {
        $permissions = $this->role->permissions()->get();
        $permissionsToDetach = [$permissions[0], $permissions[2]];
        DetachPermissionsFromRoleAction::make()->handle($this->role, $permissionsToDetach);

        $this->assertEqualsCanonicalizing(
            [$permissions[1]->getKey()],
            Role::find($this->role->getKey())
                ->permissions()
                ->pluck('id')
                ->toArray()
        );
    }

    public function testDetachPermissionFromRole(): void
    {
        $permissions = $this->role->permissions()->get();
        DetachPermissionsFromRoleAction::make()->handle($this->role, $permissions[1]);

        $this->assertEqualsCanonicalizing(
            [$permissions[0]->getKey(), $permissions[2]->getKey()],
            Role::find($this->role->getKey())
                ->permissions()
                ->pluck('id')
                ->toArray()
        );
    }
}
