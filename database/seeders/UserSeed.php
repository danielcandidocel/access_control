<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insertOrIgnore([
                                          'name'     => 'Super Admin',
                                          'email'    => 'superadmin@example.com',
                                          'password' => bcrypt('password'),
                                      ]);
        User::query()->insertOrIgnore([
                                          'name'     => 'Admin',
                                          'email'    => 'admin@example.com',
                                          'password' => bcrypt('password'),
                                      ]);
    }
}
