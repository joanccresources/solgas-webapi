<?php

namespace Database\Seeders;

use App\Enums\ModelStatusEnum;
use App\Models\AttributeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttributeType::create([
            'name' => 'Texto',
            'type' => 'text',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Área de texto',
            'type' => 'textarea',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Opciones múltiples',
            'type' => 'select',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Opciones múltiples con buscador',
            'type' => 'lookup',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Fecha',
            'type' => 'date',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Fecha y hora',
            'type' => 'datetime',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Numérico',
            'type' => 'integer',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Decimal',
            'type' => 'decimal',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);

        AttributeType::create([
            'name' => 'Booleano',
            'type' => 'boolean',
            'active' => ModelStatusEnum::ACTIVE->value
        ]);
    }
}
