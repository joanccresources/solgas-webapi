<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AttributeTypeSeeder::class);
        $this->call(ContentMasterSocialNetworkSeeder::class);
        $this->call(MasterUbigeoTableSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(ModuleCookieSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UsersTableSeeder::class);

        //pages
        $this->call(PageFieldTypeSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(PageSectionSeeder::class);
        $this->call(PageFieldSeeder::class);
        $this->call(PageMultipleFieldSeeder::class);
        $this->call(PageMultipleFieldDataSeeder::class);
        $this->call(PageMultipleFieldSectionSeeder::class);

        //Employments
        $this->call(EmploymentTypeSeeder::class);

        //General Information
        $this->call(GeneralInformationSeeder::class);

        //nuevo seeder registrado el 20/02/2025
        $this->call(PageSectionFieldSeeder::class);

        //nuevo seeder registrado el 25/02/2025
        $this->call(PageSectionFieldSeeder::class);

        $this->call(ContentMenuTypeSeeder::class);

        //nuevo seeder registrado el 16/03/2025
        $this->call(TypeMapSeeder::class);



        #SEEDERS ELIMINABLES
        //$users = User::factory(100)->create();

        //$role = Role::where('id', 2)->first();
        //$users->each(function ($user) use ($role) {
        //    $user->assignRole($role);
        //});

        //Employments
        //$this->call(EmploymentAreaSeeder::class);
        //$this->call(EmploymentSeeder::class);

        //leads
        //$this->call(LeadSeeder::class);
        //$this->call(LeadDistributorSeeder::class);
        //$this->call(LeadEmailDestinationSeeder::class);
        //$this->call(LeadServiceStationSeeder::class);

        //posts
        // Crea 10 categorías
        //\App\Models\Category::factory(100)->create();
        // Crea 10 tags
        //\App\Models\Tag::factory(100)->create();
        // Crea 50 posts y sus relaciones
        //\App\Models\Post::factory(200)
        //    ->has(\App\Models\CategoryPost::factory()->count(2), 'categoryPostRels') // Relación muchos a muchos con Category
        //    ->has(\App\Models\TagPost::factory()->count(2), 'tagPostRels')      // Relación muchos a muchos con Tag
        //    ->has(\App\Models\PostSimilar::factory()->count(5), 'similarPostRels') // Relación uno a muchos con PostSimilar
        //    ->create();
    }
}
