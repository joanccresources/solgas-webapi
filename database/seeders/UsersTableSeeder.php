<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Superadministrador')->first();
        $role_admin = Role::where('name', 'Administrador')->first();

        User::create([
            'name' => 'Javier Leonardo',
            'email' => 'javier@admin.pe',
            'phone' => '981844312',
            'image' => '',
            'active' => ModelStatusEnum::ACTIVE->value,
            'email_verified_at' => now(),
            'password' => Hash::make('123$qweR'),
        ])->assignRole($role);

        User::create([
            'name' => 'Yameli Carrillo',
            'email' => 'yameli@admin.pe',
            'phone' => '981844312',
            'image' => '',
            'active' => ModelStatusEnum::ACTIVE->value,
            'email_verified_at' => now(),
            'password' => Hash::make('123$qweR'),
        ])->assignRole($role);

        User::create([
            'name' => 'Gianmardo Oliva',
            'email' => 'gianmarco@admin.pe',
            'phone' => '981844312',
            'image' => '',
            'active' => ModelStatusEnum::ACTIVE->value,
            'email_verified_at' => now(),
            'password' => Hash::make('123$qweR'),
        ])->assignRole($role);

        User::create([
            'name' => 'Test',
            'email' => 'test@admin.pe',
            'phone' => '981844312',
            'image' => '',
            'active' => ModelStatusEnum::ACTIVE->value,
            'email_verified_at' => now(),
            'password' => Hash::make('123$qweR'),
        ])->assignRole($role_admin);
    }
}
