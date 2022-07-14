<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'poster', 'tasker'];
        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role],
                ['name' => $role],
            );
        }

        $userAdmin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            ['first_name' => 'Hung', 'last_name' => 'Nguyen', 'password' => Hash::make('Admin12345'), 'email_verified_at' => now()]
        );
        $userAdmin->assignRole(1);
    }
}
