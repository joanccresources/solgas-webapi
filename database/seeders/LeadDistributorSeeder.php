<?php

namespace Database\Seeders;

use App\Models\LeadDistributor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadDistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadDistributor::factory()->count(2)->create();
    }
}
