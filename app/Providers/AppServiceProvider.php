<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('permission', function (User $user, string $permissionName) {
            if (auth()->user()->isSuperAdmin()) {
                return true;
            }
            $permission = Permission::query()->where('name', $permissionName)->with('roles')->first();
            $roles      = $permission?->roles->pluck('id')->toArray();

            if (!empty($permission) && !empty($roles)) {
                if (UserRole::query()->where('user_id', $user->id)->whereIn('role_id', $roles)->exists()) {
                    return true;
                }
            }

            return false;
        });
    }
}
