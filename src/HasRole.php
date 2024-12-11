<?php

namespace ZankoKhaledi\LaravelRolePermissions;

use App\Models\Role;

trait HasRole
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function permissions(): array
    {
        return $this->roles()->get()->flatMap(function (Role $role) {
            return $role->permissions()->pluck('name')->toArray();
        });
    }

    public function hasPermission(string $permission): bool
    {
        $permissions = $this->roles()->get()->flatMap(function (Role $role) {
            return $role->permissions()->pluck('name')->toArray();
        });

        return in_array($permission, $permissions);
    }
}