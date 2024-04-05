<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            XepareSeeder::class,
        ]);

        DB::transaction(function () {
            return tap(User::create([
                'name' => 'Admin',
                'firstname' => 'Max',
                'lastname' => 'Musterwiese',
                'email' => 'admin@example.com',
                'password' => '123admin456',
                'email_verified_at' => now()
            ]), function (User $user) {
                $user->refresh();
                $user->assignRole(RoleEnum::SUPER_ADMIN->value);
            });
        });
    }
}
