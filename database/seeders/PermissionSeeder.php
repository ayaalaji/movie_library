<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'add movie',
            'update movie',
            'delete movie'
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }    
    }
}
