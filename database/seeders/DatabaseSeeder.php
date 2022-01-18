<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleSeeder::class);
        $this->call(CompanySeeder::class);
        \App\Models\User::factory(20)->create();
        \App\Models\Company::factory(15)->create();
    }
}
