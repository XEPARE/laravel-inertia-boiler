<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

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
    }
}
