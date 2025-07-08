<?php

namespace Database\Seeders;

use App\Models\LeadServiceStation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadServiceStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadServiceStation::factory()->count(2)->create();
    }
}
