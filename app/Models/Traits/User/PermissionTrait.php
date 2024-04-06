<?php


namespace App\Models\Traits\User;


use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

trait PermissionTrait
{

    public function permissionsToArray(): Collection|array|\Illuminate\Support\Collection
    {
        return ($this->hasRole(RoleEnum::SUPER_ADMIN->value) ? Permission::all() : $this->getAllPermissions())
            ->mapWithKeys(fn($permission) => [$permission['name'] => true]);
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
