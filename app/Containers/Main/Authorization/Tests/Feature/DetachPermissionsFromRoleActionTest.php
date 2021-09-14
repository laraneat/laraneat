<?php

namespace App\Containers\Main\Authorization\Tests\Feature;

use App\Containers\Main\Authorization\Actions\DetachPermissionsFromRoleAction;
use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tests\ApiTestCase;

/**
 * @group authorization
 * @group feature
 */
class DetachPermissionsFromRoleActionTest extends ApiTestCase
{
    private Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpData();
    }

    public function setUpData(): void
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
            [$permissions[1]->id],
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
            [$permissions[1]->id],
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
            [$permissions[0]->id, $permissions[2]->id],
            Role::find($this->role->getKey())
                ->permissions()
                ->pluck('id')
                ->toArray()
        );
    }
}
