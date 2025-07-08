<?php

namespace Database\Seeders;

use App\Models\PageField;
use App\Models\PageSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSectionFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //new fields
        PageField::insert(
            [
                [
                    'name' => 'Subtitulo naranja',
                    'variable' => 'sub_titulo_naranja',
                    'index' => 3,
                    'page_section_id' => 32,
                    'page_field_type_id' => 1,
                    'created_at' => '2025-01-20 00:12:24',
                    'updated_at' => '2025-01-20 00:12:24',
                ],
            ]
        );
        PageField::insert(
            [
                [
                    'name' => 'Subtitulo naranja',
                    'variable' => 'sub_titulo_naranja',
                    'index' => 3,
                    'page_section_id' => 40,
                    'page_field_type_id' => 1,
                    'created_at' => '2025-01-20 00:12:24',
                    'updated_at' => '2025-01-20 00:12:24',
                ],
            ]
        );


        $section = PageSection::insertGetId([
            'name' => 'Promociones',
            'index' => 5,
            'page_id' => 5,
        ]);

        PageField::insert([
            [
                'name' => 'Descripción',
                'variable' => 'descripcion',
                'page_field_type_id' => 1,
                'index' => 1,
                'page_section_id' => $section,
            ],
            [
                'name' => 'Texto botón',
                'variable' => 'texto_boton',
                'page_field_type_id' => 1,
                'index' => 2,
                'page_section_id' => $section,
            ],
            [
                'name' => 'Enlace botón',
                'variable' => 'enlace_boton',
                'page_field_type_id' => 1,
                'index' => 3,
                'page_section_id' => $section,
            ],
        ]);
    }
}
