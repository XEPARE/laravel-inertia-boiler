<?php


namespace App\Models;


use App\Helpers\Traits\SearchableTrait;

class Role extends \Spatie\Permission\Models\Role
{
    const SUPER_ADMIN = 'Super Admin';
    const ADMIN = 'Admin';

    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'roles.name' => 10,
            'roles.guard_name' => 10,
        ],
    ];

    public function update(array $attributes = [], array $options = [])
    {
        $this->syncPermissions(array_key_exists('permissions', $attributes) ? array_values($attributes['permissions']) : []);
        return parent::update($attributes, $options);
    }

    public function scopeSearchPagination($query)
    {
        return $query->search(request('search'), null, true, true)->paginate(request('limit', 25));
    }

}
