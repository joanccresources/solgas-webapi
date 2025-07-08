<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'id' => 1,
            'name' => 'Inicio',
            'slug' => 'inicio',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/',
            'created_at' => Carbon::now(),
        ]);

        Page::create([
            'id' => 2,
            'name' => 'Quiero ser distribuidor',
            'slug' => 'quiero-ser-distribuidor',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/quiero-ser-distribuidor',
            'created_at' => Carbon::now()->addSeconds(1),
        ]);

        Page::create([
            'id' => 3,
            'name' => 'Nosotros - Propósito solgas',
            'slug' => 'nosotros-proposito-solgas',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/nosotros/proposito-solgas',
            'created_at' => Carbon::now()->addSeconds(2),
        ]);

        // Aquí empiezan los que faltaban:

        Page::create([
            'id' => 5,
            'name' => 'Productos y servicios - Hogar',
            'slug' => 'productos-y-servicios-hogar',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/hogar',
            'created_at' => Carbon::now()->addSeconds(3),
        ]);

        Page::create([
            'id' => 6,
            'name' => 'Productos y servicios - Hogar - Balón 10kg',
            'slug' => 'productos-y-servicios-hogar-balon-10kg',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/hogar/balon-de-10kg',
            'created_at' => Carbon::now()->addSeconds(4),
        ]);

        Page::create([
            'id' => 7,
            'name' => 'Productos y servicios - Hogar - Balón 45kg',
            'slug' => 'productos-y-servicios-hogar-balon-45kg',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/hogar/balon-de-45kg',
            'created_at' => Carbon::now()->addSeconds(5),
        ]);

        Page::create([
            'id' => 8,
            'name' => 'Productos y servicios - Hogar - Kit regulador premium',
            'slug' => 'productos-y-servicios-hogar-kit-regulador-premium',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/hogar/kit-regulador-premium',
            'created_at' => Carbon::now()->addSeconds(6),
        ]);

        Page::create([
            'id' => 9,
            'name' => 'Productos y servicios - Pyme - Balón 45kg',
            'slug' => 'productos-y-servicios-pyme-balon-45kg',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/pyme/balon-de-45kg',
            'created_at' => Carbon::now()->addSeconds(7),
        ]);

        Page::create([
            'id' => 10,
            'name' => 'Productos y servicios - Pyme',
            'slug' => 'productos-y-servicios-pyme',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/pyme',
            'created_at' => Carbon::now()->addSeconds(8),
        ]);

        Page::create([
            'id' => 11,
            'name' => 'Productos y servicios - GLP vehicular',
            'slug' => 'productos-y-servicios-glp-vehicular',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/glp-vehicular',
            'created_at' => Carbon::now()->addSeconds(9),
        ]);

        Page::create([
            'id' => 12,
            'name' => 'Productos y servicios - GLP vehicular - Como adquirir',
            'slug' => 'productos-y-servicios-glp-vehicular-como-adquirir',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/productos-y-servicios/glp-vehicular/como-adquirir-glp-vehicular',
            'created_at' => Carbon::now()->addSeconds(10),
        ]);

        Page::create([
            'id' => 13,
            'name' => 'Sostenibilidad',
            'slug' => 'sostenibilidad',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/sostenibilidad',
            'created_at' => Carbon::now()->addSeconds(11),
        ]);

        Page::create([
            'id' => 14,
            'name' => 'Promociones',
            'slug' => 'promociones',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/promociones',
            'created_at' => Carbon::now()->addSeconds(12),
        ]);

        Page::create([
            'id' => 15,
            'name' => 'Sostenibilidad - Aporte pais',
            'slug' => 'sostenibilidad-aporte-pais',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/sostenibilidad/aporte-pais',
            'created_at' => Carbon::now()->addSeconds(13),
        ]);

        Page::create([
            'id' => 16,
            'name' => 'Noticias',
            'slug' => 'noticias',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/noticias',
            'created_at' => Carbon::now()->addSeconds(14),
        ]);

        Page::create([
            'id' => 17,
            'name' => 'Contacto',
            'slug' => 'contacto',
            'active' => ModelStatusEnum::ACTIVE->value,
            'path' => '/contacto',
            'created_at' => Carbon::now()->addSeconds(15),
        ]);
    }
}
