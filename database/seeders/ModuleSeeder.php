<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create([
            'name' => 'Dashboard',
            'singular_name' => 'dashboard',
            'assigned' => 'dashboard.',
            'slug' => '/dashboard',
            'icon' => 'solar:pie-chart-2-bold-duotone',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => false,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 1
        ]);


        Module::create([
            'name' => 'Contenido',
            'singular_name' => 'contenido',
            'assigned' => 'contenido.',
            'slug' => '/contenido',
            'icon' => 'solar:book-2-bold-duotone',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]);
        Module::create([
            'name' => 'Páginas',
            'singular_name' => 'página',
            'assigned' => 'contenido.paginas.',
            'slug' => '/contenido/paginas',
            'icon' => '',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Contenido')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 1
        ]);
        Module::create([
            'name' => 'Header',
            'singular_name' => 'header',
            'assigned' => 'contenido.header.',
            'slug' => '/contenido/header',
            'icon' => '',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Contenido')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 4
        ]);
        Module::create([
            'name' => 'Footer',
            'singular_name' => 'footer',
            'assigned' => 'contenido.footer.',
            'slug' => '/contenido/footer',
            'icon' => '',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Contenido')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 5
        ]);




        /* Module::create([
            'name' => 'Empleos',
            'singular_name' => 'empleo',
            'assigned' => 'empleos.',
            'slug' => '/empleos',
            'icon' => 'solar:backpack-bold-duotone',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 4
        ]);
        Module::create([
            'name' => 'Tipos',
            'singular_name' => 'tipo',
            'assigned' => 'empleos.tipos.',
            'slug' => '/empleos/tipos',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Empleos')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 1
        ]);
        Module::create([
            'name' => 'Áreas',
            'singular_name' => 'área',
            'assigned' => 'empleos.areas.',
            'slug' => '/empleos/areas',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Empleos')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]);
        Module::create([
            'name' => 'Publicaciones',
            'singular_name' => 'publicación',
            'assigned' => 'empleos.publicaciones.',
            'slug' => '/empleos/publicaciones',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Empleos')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 3
        ]); */


        Module::create([
            'name' => 'Noticias',
            'singular_name' => 'noticia',
            'assigned' => 'noticias.',
            'slug' => '/noticias',
            'icon' => 'solar:notebook-bookmark-bold-duotone',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 3
        ]);
        Module::create([
            'name' => 'Etiquetas',
            'singular_name' => 'etiqueta',
            'assigned' => 'noticias.etiquetas.',
            'slug' => '/noticias/etiquetas',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Noticias')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 1
        ]);
        Module::create([
            'name' => 'Categorías',
            'singular_name' => 'categoría',
            'assigned' => 'noticias.categorias.',
            'slug' => '/noticias/categorias',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Noticias')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]);
        Module::create([
            'name' => 'Publicaciones',
            'singular_name' => 'publicación',
            'assigned' => 'noticias.publicaciones.',
            'slug' => '/noticias/publicaciones',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Noticias')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 3
        ]);





        Module::create([
            'name' => 'SEO',
            'singular_name' => 'seo',
            'assigned' => 'seo.',
            'slug' => '/seo',
            'icon' => 'solar:cloud-check-linear',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 4
        ]);
        Module::create([
            'name' => 'Redes sociales',
            'singular_name' => 'red social',
            'assigned' => 'redes-sociales.',
            'slug' => '/redes-sociales',
            'icon' => 'solar:like-bold',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 5
        ]);
        Module::create([
            'name' => 'Reporte de Sostenibilidad',
            'singular_name' => 'reporte de sostenibilidad',
            'assigned' => 'reporte-sostenibilidad.',
            'slug' => '/reporte-sostenibilidad',
            'icon' => 'solar:hamburger-menu-linear',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 6
        ]);



        Module::create([
            'name' => 'Mapas',
            'singular_name' => 'mapa',
            'assigned' => 'mapas.',
            'slug' => '/mapas',
            'icon' => 'solar:map-bold',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 7
        ]);
        Module::create([
            'name' => 'Distribuidores',
            'singular_name' => 'distribuidor',
            'assigned' => 'mapas.distribuidores.',
            'slug' => '/mapas/distribuidores',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Mapas')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 1
        ]);
        Module::create([
            'name' => 'Estaciones de servicios',
            'singular_name' => 'estación de servicio',
            'assigned' => 'mapas.estaciones-de-servicios.',
            'slug' => '/mapas/estaciones-de-servicios',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Mapas')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]);



        Module::create([
            'name' => 'Leads',
            'singular_name' => 'lead',
            'assigned' => 'leads.',
            'slug' => '/leads',
            'icon' => 'solar:people-nearby-bold-duotone',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 8
        ]);
        Module::create([
            'name' => 'Contactos',
            'singular_name' => 'contacto',
            'assigned' => 'leads.contactos.',
            'slug' => '/leads/contactos',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Leads')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 1
        ]);
        /* Module::create([
            'name' => 'Trabaja con nosotros',
            'singular_name' => 'trabaja con nosotros',
            'assigned' => 'leads.trabaja-con-nosotros.',
            'slug' => '/leads/trabaja-con-nosotros',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Leads')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]); */
        Module::create([
            'name' => 'Estación de servicios',
            'singular_name' => 'estación de servicio',
            'assigned' => 'leads.estacion-de-servicios.',
            'slug' => '/leads/estacion-de-servicios',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Leads')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 3
        ]);
        Module::create([
            'name' => 'Distribuidores',
            'singular_name' => 'distribuidor',
            'assigned' => 'leads.distribuidores.',
            'slug' => '/leads/distribuidores',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Leads')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 4
        ]);
        Module::create([
            'name' => 'Emails de recepción',
            'singular_name' => 'email de recepción',
            'assigned' => 'leads.emails-de-recepcion.',
            'slug' => '/leads/emails-de-recepcion',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Leads')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 5
        ]);




        Module::create([
            'name' => 'Configuración',
            'singular_name' => 'configuración',
            'assigned' => 'configuracion.',
            'slug' => '/configuracion',
            'icon' => 'solar:settings-bold-duotone',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 9
        ]);
        Module::create([
            'name' => 'Información general',
            'singular_name' => 'información general',
            'assigned' => 'configuracion.informacion-general.',
            'slug' => '/configuracion/informacion-general',
            'icon' => '',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Configuración')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 2
        ]);
        Module::create([
            'name' => 'Backups',
            'singular_name' => 'backup',
            'assigned' => 'configuracion.backup.',
            'slug' => '/configuracion/backup',
            'icon' => '',
            'per_page' => '',
            'page' => '',
            'sort_by' => '',
            'order_direction' => '',
            'is_crud' => false,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Configuración')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 3
        ]);
        Module::create([
            'name' => 'Actividad de los usuarios',
            'singular_name' => 'actividad del usuario',
            'assigned' => 'configuracion.actividad-usuario.',
            'slug' => '/configuracion/actividad-usuario',
            'icon' => '',
            'per_page' => 10,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Configuración')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 4
        ]);
        Module::create([
            'name' => 'Permisos',
            'singular_name' => 'permiso',
            'assigned' => 'configuracion.permisos.',
            'slug' => '/configuracion/permisos',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'id',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Configuración')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::DISABLED->value,
            'index' => 13
        ]);
        Module::create([
            'name' => 'Roles',
            'singular_name' => 'rol',
            'assigned' => 'configuracion.roles.',
            'slug' => '/configuracion/roles',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Configuración')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 14
        ]);
        Module::create([
            'name' => 'Usuarios',
            'singular_name' => 'usuario',
            'assigned' => 'configuracion.usuarios.',
            'slug' => '/configuracion/usuarios',
            'icon' => '',
            'per_page' => 25,
            'page' => 1,
            'sort_by' => 'created_at',
            'order_direction' => 'DESC',
            'is_crud' => true,
            'show_in_sidebar' => true,
            'is_removable' => true,
            'module_id' => Module::where('name', 'Configuración')->whereNull('module_id')->first()->id,
            'active' => ModelStatusEnum::ACTIVE->value,
            'index' => 15
        ]);
    }
}
