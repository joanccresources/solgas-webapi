<?php

namespace Database\Seeders;

use App\Models\ContentMasterSocialNetwork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentMasterSocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentMasterSocialNetwork::create([
            'name' => 'Facebook',
            'icon' => 'facebook',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'Twitter',
            'icon' => 'twitter',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'Whatsapp',
            'icon' => 'whatsapp',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'Youtube',
            'icon' => 'youtube',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'Messenger',
            'icon' => 'messenger',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'LinkedIn',
            'icon' => 'linkedin',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'Instagram',
            'icon' => 'instagram',
        ]);
        ContentMasterSocialNetwork::create([
            'name' => 'Tik Tok',
            'icon' => 'tiktok',
        ]);
    }
}
