<?php

namespace ZankoKhaledi\LaravelRolePermissions\Providers;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../config/role_permissions.php" => config_path('role_permissions.php')
        ],'config');

        $this->publishesMigrations([
            __DIR__ . "/../database/migrations" => database_path('migrations')
        ]);

        $this->publishes([
            __DIR__ . "/../Models/Role.php" => app_path('Models/Role.php'),
            __DIR__ . "/../Models/Permission.php.php" => app_path('Models/Permission.php'),
            __DIR__ . "/../Models/RoleUser.php.php" => app_path('Models/RoleUser.php'),
        ],'models');

        $this->publishes([
            __DIR__ . "/../Middleware/EnsureUserHasRole.php" => app_path('Http/Middleware/EnsureUserHasRole.php')
        ],'middleware');

        $this->publishes([
            __DIR__ . "/RoleServiceProvider.php" => app_path('Providers/RoleServiceProvider.php')
        ],'providers');
    }
}