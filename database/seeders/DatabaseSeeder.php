<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        \DB::transaction(function () {
            return tap(User::create([
                'name' => 'Admin',
                'firstname' => 'Max',
                'lastname' => 'Musterwiese',
                'email' => 'admin@example.com',
                'password' => \Hash::make('123admin456'),
                'email_verified_at' => now()
            ]), function (User $user) {
                $user->refresh();
                $user->assignRole(Role::SUPER_ADMIN);
            });
        });
    }
}
