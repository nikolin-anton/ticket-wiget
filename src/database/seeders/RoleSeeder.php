<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $permissions_admin = Permission::create(['name' => 'full_manage_tickets']);
        $role_admin->givePermissionTo($permissions_admin);

        $role_manager = Role::create(['name' => 'manager']);
        $permissions_manager = Permission::create(['name' => 'edit_tickets']);
        $role_manager->givePermissionTo($permissions_manager);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => '12345678',
        ])->assignRole($role_admin);

        User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@mail.com',
            'password' => '12345678',
        ])->assignRole($role_manager);
    }
}
