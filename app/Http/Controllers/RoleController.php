<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomNotAuthorizationException;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RolePermissionsResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Role::all());
    }

    public function store(RoleCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $role = Role::create($data);

        return response()->json($role);
    }

    public function show(Role $role): JsonResponse
    {
        return response()->json($role);
    }

    /**
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return JsonResponse
     * @throws CustomNotAuthorizationException
     */
    public function update(RoleUpdateRequest $request, Role $role): JsonResponse
    {
        if ($role->default_system) {
            throw new CustomNotAuthorizationException('Cannot update default system role', 403);
        }
        $role->update($request->validated());

        return response()->json($role);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     * @throws CustomNotAuthorizationException
     */
    public function destroy(Role $role): JsonResponse
    {
        if ($role->default_system) {
            throw new CustomNotAuthorizationException('Cannot delete default system role', 403);
        }
        $role->delete();

        return response()->json([], 204);
    }

    public function showPermissions(Role $role)
    {
        return response()->json(new RolePermissionsResource($role));
    }

    public function syncPermission(Request $request): JsonResponse
    {
        $request->validate([
                               'role_id'       => 'required|integer|exists:roles,id',
                               'permissions'   => 'required|array',
                               'permissions.*' => 'integer|exists:permissions,id',
                           ]);

        $role = Role::find($request->role_id);
        $role->permissions()->sync($request->permissions);

        return response()->json(new RolePermissionsResource($role));
    }
}
