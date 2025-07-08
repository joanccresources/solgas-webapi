<?php

namespace Database\Seeders;

use App\Models\PageMultipleField;
use Illuminate\Database\Seeder;

class PageMultipleFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageMultipleField::create([
            'id' => 1,
            'name' => 'Banner principal',
        ]);

        PageMultipleField::create([
            'id' => 2,
            'name' => 'Distribuidores',
        ]);

        PageMultipleField::create([
            'id' => 3,
            'name' => 'Propuesta de valor',
        ]);

        PageMultipleField::create([
            'id' => 4,
            'name' => 'Valores solgas',
        ]);

        PageMultipleField::create([
            'id' => 5,
            'name' => 'Historias inspiradoras',
        ]);

        PageMultipleField::create([
            'id' => 6,
            'name' => '¿Por qué solgas? - Hogar',
        ]);

        PageMultipleField::create([
            'id' => 7,
            'name' => 'Promociones',
        ]);

        PageMultipleField::create([
            'id' => 9,
            'name' => 'Beneficios - Hogar - Balon 10kg',
        ]);

        PageMultipleField::create([
            'id' => 10,
            'name' => 'Usos - Hogar - Balon 10kg',
        ]);

        PageMultipleField::create([
            'id' => 11,
            'name' => 'Beneficios - Hogar - Balon 45kg',
        ]);

        PageMultipleField::create([
            'id' => 12,
            'name' => 'Usos - Hogar - Balon 45kg',
        ]);

        PageMultipleField::create([
            'id' => 13,
            'name' => 'Beneficios - Hogar - Kit regulador premium',
        ]);

        PageMultipleField::create([
            'id' => 14,
            'name' => '¿Por qué solgas? - Negocio',
        ]);

        PageMultipleField::create([
            'id' => 15,
            'name' => 'Beneficios - Negocio - Balon 45kg',
        ]);

        PageMultipleField::create([
            'id' => 16,
            'name' => 'Usos - Negocio - Balon 45kg',
        ]);

        PageMultipleField::create([
            'id' => 17,
            'name' => 'Beneficios - GLP vehicular',
        ]);

        PageMultipleField::create([
            'id' => 18,
            'name' => 'Estaciones',
        ]);

        PageMultipleField::create([
            'id' => 19,
            'name' => 'Alianzas',
        ]);

        PageMultipleField::create([
            'id' => 21,
            'name' => 'Hitos',
        ]);

        PageMultipleField::create([
            'id' => 22,
            'name' => 'Certificaciones',
        ]);

        PageMultipleField::create([
            'id' => 23,
            'name' => 'Reconocimientos',
        ]);

        PageMultipleField::create([
            'id' => 24,
            'name' => 'Aporte país',
        ]);

        PageMultipleField::create([
            'id' => 25,
            'name' => 'Reportes',
        ]);
    }
}
