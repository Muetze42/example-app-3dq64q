<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $role = Role::firstOrCreate(['name' => 'moderator']);
        $permission = Permission::create(['name' => 'edit comments']);
        $role->givePermissionTo($permission);

        $role = Role::firstOrCreate(['name' => 'writer']);
        $permission = Permission::create(['name' => 'edit articles']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'edit stories']);
        $role->givePermissionTo($permission);

        $admin->syncPermissions(Permission::pluck('name')->toArray());
    }
}
