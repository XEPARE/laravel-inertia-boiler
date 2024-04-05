<?php

return [

    // Permissions
    'permissions' => [
        // Here our custom permissions
    ],

    // Models
    'models' => $permissionModels = [
        \App\Models\User::class,

        // Add some models (for crud)
    ],

    // Defined roles and there permission list
    'roles' => [

        \App\Enums\RoleEnum::SUPER_ADMIN->value => [], // Whoever has this role bypasses the entire permission system

        // Assign all permissions without delete for the administrator
        \App\Enums\RoleEnum::ADMIN->value => collect($permissionModels)->mapWithKeys(fn($key) => [
            $key => [
                'read',
                'update',
                'create',
            ]
        ])->toArray(),
    ],

];
