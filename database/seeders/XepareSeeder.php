<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class XepareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Generate CRUD permissions of Model
         */
        foreach (config('xepare.models') as $model) {
            foreach (['create', 'read', 'update', 'delete'] as $crud)
                Permission::create([
                    'name' => sprintf('%s.%s', Str::snake(class_basename($model), '.'), $crud)
                ]);
        }

        /**
         * Register custom permissions
         */
        foreach (config('rservices.permissions') as $value) {
            Permission::create([
                'name' => $value
            ]);
        }

        /**
         * Register roles & attach permissions
         */
        foreach (config('xepare.roles') as $name => $models) {
            /** @var Role $role */
            $role = Role::create(['name' => $name]);
            if (is_null($name)) continue;
            // Give permissions
            collect($models)->map(fn($permissions, $model) => collect($permissions)->values()->map(
                fn($type) => sprintf('%s.%s', Str::snake(class_basename($model), '.'), $type)
            ))->each(fn($data) => $data->values()->each(fn($permission) => $role->givePermissionTo($permission)));
        }
    }
}
