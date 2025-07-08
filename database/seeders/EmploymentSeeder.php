<?php

namespace Database\Seeders;

use App\Models\Employment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employment::factory(200)
            ->has(\App\Models\EmploymentSimilar::factory()->count(5), 'similarEmploymentRels')
            ->create();
    }
}
