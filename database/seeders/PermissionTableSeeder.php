<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // role
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            // user
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            // cms
            'cms-list',
            'cms-update',
            // room
            'room-list',
            'room-create',
            'room-edit',
            'room-delete',
         ];
         
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
