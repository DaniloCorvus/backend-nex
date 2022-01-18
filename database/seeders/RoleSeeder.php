<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();

        $role = new Role();
        $role->name = 'user';
        $role->description = 'User';
        $role->save();

        $user = new User();
        $user->first_name = 'Admin';
        $user->last_name = 'Admin';
        $user->company_id = 1;
        $user->email = 'admin@test.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('password'); // password
        $user->remember_token = Hash::make('password');
        $user->save();

        $user->roles()->attach(Role::where('name', 'admin')->first());
    }
}
