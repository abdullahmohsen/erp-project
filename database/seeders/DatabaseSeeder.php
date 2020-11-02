<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(LaratrustSeeder::class);

        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);

    }
}
