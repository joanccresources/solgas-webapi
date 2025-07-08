<?php

namespace Database\Seeders;

use App\Models\LeadWorkWithUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadWorkWithUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadWorkWithUs::factory()->count(1)->create();
    }
}
