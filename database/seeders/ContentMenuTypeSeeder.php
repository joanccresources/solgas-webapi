<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\ContentMenuType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentMenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentMenuType::create([
            'name' => 'Imagen',
            'type' => 'image',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        ContentMenuType::create([
            'name' => 'Video',
            'type' => 'video',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        ContentMenuType::create([
            'name' => 'Documento',
            'type' => 'document',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        ContentMenuType::create([
            'name' => 'Url',
            'type' => 'url',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
    }
}
