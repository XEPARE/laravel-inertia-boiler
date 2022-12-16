<?php


namespace App\Models\Traits\User;


use App\Models\Role;
use Spatie\Permission\Models\Permission;

trait PermissionTrait
{

    public function permissionsToArray(): \Illuminate\Database\Eloquent\Collection|array|\Illuminate\Support\Collection
    {
        return ($this->hasRole(Role::SUPER_ADMIN) ? Permission::all() : $this->getAllPermissions())->mapWithKeys(fn($permission) => [$permission['name'] => true]);
    }

    public function setPermissionsAttribute(array $value)
    {
        $this->syncPermissions($value);
    }

    public function setRolesAttribute(array $value)
    {
        $this->syncRoles($value);
    }

}
