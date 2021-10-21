<?php

namespace App\Modules\Authorization\Tests\Feature\Actions;

use App\Modules\Authorization\Actions\DetachRolesFromUserAction;
use App\Modules\Authorization\Models\Role;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;

/**
 * @group authorization
 * @group feature
 */
class DetachRolesFromUserActionTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpData();
    }

    protected function setUpData(): void
    {
        $this->user = User::factory()
            ->has(Role::factory()->count(3))
            ->create();
    }

    public function testDetachRoleIdsFromUser(): void
    {
        $roleIds = $this->user->roles()->pluck('id')->toArray();
        $roleIdsToDetach = [$roleIds[0], $roleIds[2]];

        DetachRolesFromUserAction::make()->handle($this->user, $roleIdsToDetach);

        $this->assertEqualsCanonicalizing(
            [$roleIds[1]],
            User::find($this->user->getKey())
                ->roles()
                ->pluck('id')
                ->toArray()
        );
    }

    public function testDetachRoleNamesFromUser(): void
    {
        $roles = $this->user->roles()->get();
        $roleNamesToDetach = [$roles[0]->name, $roles[2]->name];
        DetachRolesFromUserAction::make()->handle($this->user, $roleNamesToDetach);

        $this->assertEqualsCanonicalizing(
            [$roles[1]->getKey()],
            User::find($this->user->getKey())
                ->roles()
                ->pluck('id')
                ->toArray()
        );
    }

    public function testDetachRoleModelsFromUser(): void
    {
        $roles = $this->user->roles()->get();
        $rolesToDetach = [$roles[0], $roles[2]];
        DetachRolesFromUserAction::make()->handle($this->user, $rolesToDetach);

        $this->assertEqualsCanonicalizing(
            [$roles[1]->getKey()],
            User::find($this->user->getKey())
                ->roles()
                ->pluck('id')
                ->toArray()
        );
    }

    public function testDetachRoleFromUser(): void
    {
        $roles = $this->user->roles()->get();
        DetachRolesFromUserAction::make()->handle($this->user, $roles[1]);

        $this->assertEqualsCanonicalizing(
            [$roles[0]->getKey(), $roles[2]->getKey()],
            User::find($this->user->getKey())
                ->roles()
                ->pluck('id')
                ->toArray()
        );
    }
}
