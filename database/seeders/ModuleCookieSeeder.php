<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class ModuleCookieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settingModule = Module::where('name', 'Configuración')->whereNull('module_id')->first();

        Module::create([
            'name' => 'Consentimiento de Cookies',
            'singular_name' => 'consentimiento de Cookie',
            'assigned' => 'configuracion.consentimiento-cookie.',
            'slug' => '/configuracion/consentimiento-cookie',
            'icon' => '',
            'per_page' => 10,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => $settingModule->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]);

        $role = Role::where('name', 'Superadministrador')->first();
        $role_admin = Role::where('name', 'Administrador')->first();

        Permission::create([
            'name' => 'configuracion.consentimiento-cookie.index',
            'module_id' =>  Module::where('assigned', 'configuracion.consentimiento-cookie.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.consentimiento-cookie.destroy',
            'module_id' =>  Module::where('assigned', 'configuracion.consentimiento-cookie.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
    }
}
