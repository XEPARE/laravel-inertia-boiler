<?php


namespace App\Models;


use App\Helpers\Traits\SearchableScope;
use App\Helpers\Traits\SearchableTrait;

/**
 * @mixin IdeHelperRole
 */
class Role extends \Spatie\Permission\Models\Role
{
    use SearchableTrait;
    use SearchableScope;

    protected $searchable = [
        'columns' => [
            'roles.name' => 10,
            'roles.guard_name' => 10,
        ],
    ];

}
