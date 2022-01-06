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

        \App\Models\Role::SUPER_ADMIN => [], // Whoever has this role bypasses the entire permission system

        // Assign all permissions without delete for the administrator
        \App\Models\Role::ADMIN => collect($permissionModels)->mapWithKeys(fn($key) => [
            $key => [
                'read',
                'update',
                'create',
            ]
        ])->toArray(),
    ],

];
