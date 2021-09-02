<?php

namespace App\Containers\Main\Authorization\UI\API\Controllers;

use App\Containers\Main\Authorization\Actions\AssignUserToRoleAction;
use App\Containers\Main\Authorization\Actions\AttachPermissionsToRoleAction;
use App\Containers\Main\Authorization\Actions\CreateRoleAction;
use App\Containers\Main\Authorization\Actions\DeleteRoleAction;
use App\Containers\Main\Authorization\Actions\DetachPermissionsFromRoleAction;
use App\Containers\Main\Authorization\Actions\ViewPermissionAction;
use App\Containers\Main\Authorization\Actions\ViewRoleAction;
use App\Containers\Main\Authorization\Actions\ListPermissionsAction;
use App\Containers\Main\Authorization\Actions\ListRolesAction;
use App\Containers\Main\Authorization\Actions\RevokeUserFromRoleAction;
use App\Containers\Main\Authorization\Actions\SyncPermissionsOnRoleAction;
use App\Containers\Main\Authorization\Actions\SyncUserRolesAction;
use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\AssignUserToRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\AttachPermissionToRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\DetachPermissionToRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\ViewPermissionRequest;
use App\Containers\Main\Authorization\UI\API\Requests\ViewRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\ListPermissionsRequest;
use App\Containers\Main\Authorization\UI\API\Requests\ListRolesRequest;
use App\Containers\Main\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\SyncPermissionsOnRoleRequest;
use App\Containers\Main\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\Main\Authorization\UI\API\Resources\PermissionResource;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Controller extends ApiController
{
    public function listPermissions(ListPermissionsRequest $request): ResourceCollection
    {
        $permissions = app(ListPermissionsAction::class)->run();
        return PermissionResource::collection($permissions);
    }

    public function viewPermission(ViewPermissionRequest $request, Permission $permission): PermissionResource
    {
        $permission = app(ViewPermissionAction::class)->run($request, $permission);
        return new PermissionResource($permission);
    }

    public function listRoles(ListRolesRequest $request): ResourceCollection
    {
        $roles = app(ListRolesAction::class)->run();
        return RoleResource::collection($roles);
    }

    public function viewRole(ViewRoleRequest $request, Role $role): RoleResource
    {
        $role = app(ViewRoleAction::class)->run($request, $role);
        return new RoleResource($role);
    }

    public function assignUserToRole(AssignUserToRoleRequest $request): UserResource
    {
        $user = app(AssignUserToRoleAction::class)->run($request);
        return new UserResource($user);
    }

    public function syncUserRoles(SyncUserRolesRequest $request): UserResource
    {
        $user = app(SyncUserRolesAction::class)->run($request);
        return new UserResource($user);
    }

    public function deleteRole(DeleteRoleRequest $request, Role $role): JsonResponse
    {
        app(DeleteRoleAction::class)->run($request, $role);
        return $this->noContent();
    }

    public function revokeRoleFromUser(RevokeUserFromRoleRequest $request): UserResource
    {
        $user = app(RevokeUserFromRoleAction::class)->run($request);
        return new UserResource($user);
    }

    public function attachPermissionToRole(AttachPermissionToRoleRequest $request): RoleResource
    {
        $role = app(AttachPermissionsToRoleAction::class)->run($request);
        return new RoleResource($role);
    }

    public function syncPermissionOnRole(SyncPermissionsOnRoleRequest $request): RoleResource
    {
        $role = app(SyncPermissionsOnRoleAction::class)->run($request);
        return new RoleResource($role);
    }

    public function detachPermissionFromRole(DetachPermissionToRoleRequest $request): RoleResource
    {
        $role = app(DetachPermissionsFromRoleAction::class)->run($request);
        return new RoleResource($role);
    }

    public function createRole(CreateRoleRequest $request): RoleResource
    {
        $role = app(CreateRoleAction::class)->run($request);
        return new RoleResource($role);
    }
}
