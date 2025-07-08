<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\TypeMap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeMap::create([
            'name' => 'Estación de servicio',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        TypeMap::create([
            'name' => 'Taller de conversión',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        TypeMap::create([
            'name' => 'Concesionaria',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        TypeMap::create([
            'name' => 'Distribuidor',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
    }
}
