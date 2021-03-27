<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->isAdmin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret')
        ]);

        \App\Models\Company::factory(2000)->create();
    }
}
