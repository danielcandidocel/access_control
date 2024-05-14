<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->insertOrIgnore([
            'id' => 1,
            'name' => 'super_admin',
            'default_system' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Role::query()->insertOrIgnore([
            'id' => 2,
            'name' => 'admin',
            'default_system' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Role::query()->insertOrIgnore([
            'id' => 3,
            'name' => 'default',
            'default_system' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        UserRole::query()->insertOrIgnore([
            'user_id' => 1,
            'role_id' => RolesEnum::SUPER_ADMIN,
        ]);

        UserRole::query()->insertOrIgnore([
            'user_id' => 2,
            'role_id' => RolesEnum::ADMIN,
        ]);

        Artisan::call('permissions:create');
    }
}
