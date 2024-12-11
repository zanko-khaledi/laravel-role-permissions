<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $rolesTable = config('role_permissions.role_table_name');
        $permissionTable = config('role_permissions.permission_table_name');
        $roleUserTable = config('role_permissions.role_user_table_name');

        if (!Schema::hasTable($rolesTable)) {
            Schema::create($rolesTable, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->json('can')->nullable();
                $table->timestamps();
            });
        }

        $role_id = 'role_id';

        if (str_ends_with($roleUserTable, 's')) {
            $role_id = substr($rolesTable, 0, -1);
            $role_id .= '_id';
        }

        if (!Schema::hasTable($roleUserTable)) {

            Schema::create($roleUserTable, function (Blueprint $table) use ($role_id,$rolesTable) {
                $table->foreignId($role_id)->constrained($rolesTable ?? 'roles')
                    ->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('user_id')->constrained('users')
                    ->cascadeOnDelete()->cascadeOnUpdate();
            });
        }

        if (!Schema::hasTable($permissionTable)) {
            Schema::create($permissionTable, function (Blueprint $table) use ($role_id, $rolesTable) {
                $table->id();
                $table->foreignId($role_id)->constrained($rolesTable ?? 'roles')
                    ->cascadeOnDelete()->cascadeOnUpdate();
                $table->string('name');
                $table->json('details')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('role_permissions.permission_table_name') ?? 'permissions');
        Schema::dropIfExists(config('role_permissions.role_user_table_name') ?? 'role_user');
        Schema::dropIfExists(config('role_permissions.role_table_name') ?? 'roles');
    }
};
