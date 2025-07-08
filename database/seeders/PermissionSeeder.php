<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'Superadministrador')->first();
        $role_admin = Role::where('name', 'Administrador')->first();
        //segun el analisis, module será un id externo y parent será el name del padre en caso, tenga sino tiene entonces será el mismo padre.


        //Dashboard
        Permission::create([
            'name' => 'dashboard.index',
            'module_id' => Module::where('assigned', 'dashboard.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);



        //Contenido

        Permission::create([
            'name' => 'contenido.paginas.index',
            'module_id' => Module::where('assigned', 'contenido.paginas.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.paginas.edit',
            'module_id' => Module::where('assigned', 'contenido.paginas.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);


        Permission::create([
            'name' => 'contenido.header.index',
            'module_id' => Module::where('assigned', 'contenido.header.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.header.create',
            'module_id' => Module::where('assigned', 'contenido.header.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.header.edit',
            'module_id' => Module::where('assigned', 'contenido.header.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.header.destroy',
            'module_id' => Module::where('assigned', 'contenido.header.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.header.order',
            'module_id' => Module::where('assigned', 'contenido.header.')->first()->id,
            'description' => 'Ordenar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'contenido.footer.index',
            'module_id' => Module::where('assigned', 'contenido.footer.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.footer.create',
            'module_id' => Module::where('assigned', 'contenido.footer.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.footer.edit',
            'module_id' => Module::where('assigned', 'contenido.footer.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.footer.destroy',
            'module_id' => Module::where('assigned', 'contenido.footer.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'contenido.footer.order',
            'module_id' => Module::where('assigned', 'contenido.footer.')->first()->id,
            'description' => 'Ordenar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);



        /* //Empleos
        Permission::create([
            'name' => 'empleos.tipos.index',
            'module_id' => Module::where('assigned', 'empleos.tipos.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.tipos.create',
            'module_id' => Module::where('assigned', 'empleos.tipos.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.tipos.edit',
            'module_id' => Module::where('assigned', 'empleos.tipos.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.tipos.destroy',
            'module_id' => Module::where('assigned', 'empleos.tipos.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'empleos.areas.index',
            'module_id' => Module::where('assigned', 'empleos.areas.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.areas.create',
            'module_id' => Module::where('assigned', 'empleos.areas.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.areas.edit',
            'module_id' => Module::where('assigned', 'empleos.areas.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.areas.destroy',
            'module_id' => Module::where('assigned', 'empleos.areas.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'empleos.publicaciones.index',
            'module_id' => Module::where('assigned', 'empleos.publicaciones.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.publicaciones.create',
            'module_id' => Module::where('assigned', 'empleos.publicaciones.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.publicaciones.edit',
            'module_id' => Module::where('assigned', 'empleos.publicaciones.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'empleos.publicaciones.destroy',
            'module_id' => Module::where('assigned', 'empleos.publicaciones.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]); */



        //Noticias
        Permission::create([
            'name' => 'noticias.etiquetas.index',
            'module_id' => Module::where('assigned', 'noticias.etiquetas.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.etiquetas.create',
            'module_id' => Module::where('assigned', 'noticias.etiquetas.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.etiquetas.edit',
            'module_id' => Module::where('assigned', 'noticias.etiquetas.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.etiquetas.destroy',
            'module_id' => Module::where('assigned', 'noticias.etiquetas.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'noticias.categorias.index',
            'module_id' => Module::where('assigned', 'noticias.categorias.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.categorias.create',
            'module_id' => Module::where('assigned', 'noticias.categorias.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.categorias.edit',
            'module_id' => Module::where('assigned', 'noticias.categorias.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.categorias.destroy',
            'module_id' => Module::where('assigned', 'noticias.categorias.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'noticias.publicaciones.index',
            'module_id' => Module::where('assigned', 'noticias.publicaciones.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.publicaciones.create',
            'module_id' => Module::where('assigned', 'noticias.publicaciones.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.publicaciones.edit',
            'module_id' => Module::where('assigned', 'noticias.publicaciones.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'noticias.publicaciones.destroy',
            'module_id' => Module::where('assigned', 'noticias.publicaciones.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);


        Permission::create([
            'name' => 'seo.index',
            'module_id' => Module::where('assigned', 'seo.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'seo.edit',
            'module_id' => Module::where('assigned', 'seo.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'redes-sociales.index',
            'module_id' => Module::where('assigned', 'redes-sociales.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'redes-sociales.create',
            'module_id' => Module::where('assigned', 'redes-sociales.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'redes-sociales.edit',
            'module_id' => Module::where('assigned', 'redes-sociales.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'redes-sociales.destroy',
            'module_id' => Module::where('assigned', 'redes-sociales.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'redes-sociales.order',
            'module_id' => Module::where('assigned', 'redes-sociales.')->first()->id,
            'description' => 'Ordenar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);


        Permission::create([
            'name' => 'reporte-sostenibilidad.index',
            'module_id' => Module::where('assigned', 'reporte-sostenibilidad.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'reporte-sostenibilidad.create',
            'module_id' => Module::where('assigned', 'reporte-sostenibilidad.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'reporte-sostenibilidad.edit',
            'module_id' => Module::where('assigned', 'reporte-sostenibilidad.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'reporte-sostenibilidad.destroy',
            'module_id' => Module::where('assigned', 'reporte-sostenibilidad.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'reporte-sostenibilidad.order',
            'module_id' => Module::where('assigned', 'reporte-sostenibilidad.')->first()->id,
            'description' => 'Ordenar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);






        //Leads
        Permission::create([
            'name' => 'leads.contactos.index',
            'module_id' => Module::where('assigned', 'leads.contactos.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.contactos.destroy',
            'module_id' => Module::where('assigned', 'leads.contactos.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        /* Permission::create([
            'name' => 'leads.trabaja-con-nosotros.index',
            'module_id' => Module::where('assigned', 'leads.trabaja-con-nosotros.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.trabaja-con-nosotros.destroy',
            'module_id' => Module::where('assigned', 'leads.trabaja-con-nosotros.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]); */

        Permission::create([
            'name' => 'leads.estacion-de-servicios.index',
            'module_id' => Module::where('assigned', 'leads.estacion-de-servicios.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.estacion-de-servicios.destroy',
            'module_id' => Module::where('assigned', 'leads.estacion-de-servicios.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'leads.distribuidores.index',
            'module_id' => Module::where('assigned', 'leads.distribuidores.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.distribuidores.destroy',
            'module_id' => Module::where('assigned', 'leads.distribuidores.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'leads.emails-de-recepcion.index',
            'module_id' => Module::where('assigned', 'leads.emails-de-recepcion.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.emails-de-recepcion.create',
            'module_id' => Module::where('assigned', 'leads.emails-de-recepcion.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.emails-de-recepcion.edit',
            'module_id' => Module::where('assigned', 'leads.emails-de-recepcion.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'leads.emails-de-recepcion.destroy',
            'module_id' => Module::where('assigned', 'leads.emails-de-recepcion.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);



        Permission::create([
            'name' => 'mapas.distribuidores.index',
            'module_id' => Module::where('assigned', 'mapas.distribuidores.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.distribuidores.create',
            'module_id' => Module::where('assigned', 'mapas.distribuidores.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.distribuidores.edit',
            'module_id' => Module::where('assigned', 'mapas.distribuidores.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.distribuidores.destroy',
            'module_id' => Module::where('assigned', 'mapas.distribuidores.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.distribuidores.order',
            'module_id' => Module::where('assigned', 'mapas.distribuidores.')->first()->id,
            'description' => 'Ordenar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'mapas.estaciones-de-servicios.index',
            'module_id' => Module::where('assigned', 'mapas.estaciones-de-servicios.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.estaciones-de-servicios.create',
            'module_id' => Module::where('assigned', 'mapas.estaciones-de-servicios.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.estaciones-de-servicios.edit',
            'module_id' => Module::where('assigned', 'mapas.estaciones-de-servicios.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.estaciones-de-servicios.destroy',
            'module_id' => Module::where('assigned', 'mapas.estaciones-de-servicios.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'mapas.estaciones-de-servicios.order',
            'module_id' => Module::where('assigned', 'mapas.estaciones-de-servicios.')->first()->id,
            'description' => 'Ordenar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);


        //Configuración
        Permission::create([
            'name' => 'configuracion.informacion-general.index',
            'module_id' => Module::where('assigned', 'configuracion.informacion-general.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.informacion-general.edit',
            'module_id' => Module::where('assigned', 'configuracion.informacion-general.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'configuracion.backup.index',
            'module_id' => Module::where('assigned', 'configuracion.backup.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.backup.download',
            'module_id' => Module::where('assigned', 'configuracion.backup.')->first()->id,
            'description' => 'Descargar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'configuracion.actividad-usuario.index',
            'module_id' =>  Module::where('assigned', 'configuracion.actividad-usuario.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'configuracion.permisos.index',
            'module_id' =>  Module::where('assigned', 'configuracion.permisos.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role]);
        Permission::create([
            'name' => 'configuracion.permisos.create',
            'module_id' =>  Module::where('assigned', 'configuracion.permisos.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role]);
        Permission::create([
            'name' => 'configuracion.permisos.edit',
            'module_id' =>  Module::where('assigned', 'configuracion.permisos.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role]);
        Permission::create([
            'name' => 'configuracion.permisos.destroy',
            'module_id' =>  Module::where('assigned', 'configuracion.permisos.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role]);

        Permission::create([
            'name' => 'configuracion.roles.index',
            'module_id' =>  Module::where('assigned', 'configuracion.roles.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.roles.create',
            'module_id' =>  Module::where('assigned', 'configuracion.roles.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.roles.edit',
            'module_id' =>  Module::where('assigned', 'configuracion.roles.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.roles.destroy',
            'module_id' =>  Module::where('assigned', 'configuracion.roles.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);

        Permission::create([
            'name' => 'configuracion.usuarios.index',
            'module_id' => Module::where('assigned', 'configuracion.usuarios.')->first()->id,
            'description' => 'Listar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.usuarios.create',
            'module_id' => Module::where('assigned', 'configuracion.usuarios.')->first()->id,
            'description' => 'Registrar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.usuarios.edit',
            'module_id' => Module::where('assigned', 'configuracion.usuarios.')->first()->id,
            'description' => 'Editar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
        Permission::create([
            'name' => 'configuracion.usuarios.destroy',
            'module_id' => Module::where('assigned', 'configuracion.usuarios.')->first()->id,
            'description' => 'Eliminar',
            'guard_name' => 'web'
        ])->assignRole([$role, $role_admin]);
    }
}
