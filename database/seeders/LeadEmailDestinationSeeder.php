<?php

namespace Database\Seeders;

use App\Models\LeadEmailDestination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadEmailDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadEmailDestination::create([
            'name' => 'Gianmardo Oliva',
            'email' => 'olivagianmarco@gmail.com',
        ]);
        LeadEmailDestination::create([
            'name' => 'Yameli Carrillo',
            'email' => 'yamelicarrillo@gmail.com',
        ]);
        LeadEmailDestination::create([
            'name' => 'Javier Leonardo',
            'email' => 'javi.leo50@gmail.com',
        ]);
    }
}
