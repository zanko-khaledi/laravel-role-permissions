<?php

namespace ZankoKhaledi\LaravelRolePermissions\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Blade::if('hasPermission',function (string $permission){
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
    }
}