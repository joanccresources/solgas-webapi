<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\PageFieldType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageFieldType::create([
            'name' => 'Entrada',
            'type' => 'input',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
        PageFieldType::create([
            'name' => 'Editor',
            'type' => 'editor',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
        PageFieldType::create([
            'name' => 'Imagen',
            'type' => 'image',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
        PageFieldType::create([
            'name' => 'Video',
            'type' => 'video',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
        PageFieldType::create([
            'name' => 'Documento',
            'type' => 'document',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
    }
}
