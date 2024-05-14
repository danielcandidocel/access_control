<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Hello World!']);
});
Route::post('/login', [LoginController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('me', [UserController::class, 'me'])->name('me');
    Route::patch('me/update/{user}', [UserController::class, 'meUpdate'])->name('me.update');

    Route::get('users/{user}/roles', [UserRoleController::class, 'show'])->name('users.roles');
    Route::post('users/sync_role', [UserRoleController::class, 'syncRole'])->name('users.syncRole');

    Route::get('roles/{role}/permissions', [RoleController::class, 'showPermissions'])->name('roles.permissions');
    Route::post('roles/sync_permission', [RoleController::class, 'syncPermission'])->name('roles.syncPermission');

    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');

    Route::apiResources([
                            'users'       => UserController::class,
                            'roles'       => RoleController::class
                        ]);
});

