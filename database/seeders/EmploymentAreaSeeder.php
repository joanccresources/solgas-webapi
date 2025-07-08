<?php

namespace Database\Seeders;

use App\Models\EmploymentArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmploymentArea::factory()->count(12)->create();
    }
}
