<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Superadministrador', 'guard_name' => 'web']);
        Role::create(['name' => 'Administrador', 'guard_name' => 'web']);
    }
}
