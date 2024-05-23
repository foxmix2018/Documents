<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::count() == 0) {
            // إنشاء الأدوار
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'user']);
            Role::create(['name' => 'editor']);
        }
    }
}
