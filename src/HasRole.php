<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRole
{
    /**
     * @return BelongsToMany
     */
    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * @return array
     */
    public function permissions(): array
    {
        return $this->roles()->get()->flatMap(function (Role $role) {
            return $role->permissions()->pluck('name');
        })->all();
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = $this->roles()->get()->flatMap(function (Role $role) {
            return $role->permissions()->pluck('name');
        })->all();

        return in_array($permission, $permissions);
    }
}