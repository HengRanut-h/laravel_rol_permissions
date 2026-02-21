<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Role Permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Permission Permissions
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',

            // Post Permissions
            'view-posts',
            'create-posts',
            'edit-posts',
            'delete-posts',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(

            [
            'name' => $permission,
            'guard_name' => 'web',
            ]);
        }
    }
}
