<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomNotAuthorizationException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateMeRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(UserCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return response()->json($user);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user->update($data);
        return response()->json($user);
    }

    /**
     * @throws CustomNotAuthorizationException
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            throw new CustomNotAuthorizationException('Cannot delete yourself', 403);
        }
        $user->delete();
        return response()->json([], 204);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function meUpdate(UserUpdateMeRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return response()->json($user);
    }

}
