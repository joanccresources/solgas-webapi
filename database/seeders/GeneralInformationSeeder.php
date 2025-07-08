<?php

namespace Database\Seeders;

use App\Models\GeneralInformation;
use Illuminate\Database\Seeder;

class GeneralInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralInformation::create([
            'logo_principal' => '',
            'logo_footer' => '',
            'phone' => '',
            'whatsapp' => '',
        ]);
    }
}
