<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRoleResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function show(User $user)
    {
        return response()->json(new UserRoleResource($user));
    }

    public function syncRole(Request $request): JsonResponse
    {
        $request->validate([
                               'user_id' => 'required|exists:users,id',
                               'roles'   => 'required|array',
                               'roles.*' => 'exists:roles,id',
                           ]);

        $user = User::find($request->user_id);
        $user->roles()->sync($request->roles);

        return response()->json(new UserRoleResource($user));
    }
}
