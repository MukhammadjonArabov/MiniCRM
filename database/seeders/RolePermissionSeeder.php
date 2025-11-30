<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);

        $permissions = [
        'ticket.create',
        'ticket.view',
        'ticket.update',
        'ticket.delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin->permissions()->sync(Permission::all());

        $managerPermissions = Permission::whereIn('name', [
            'ticket.view',
            'ticket.update'
        ])->get();
    }
}
