<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CollegeSeeder::class,
            ProgramSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            AuthorSeeder::class,
            SubjectSeeder::class,
            ThesisSeeder::class,
            PlaceOfPublicationSeeder::class
        ]);
    }
}
