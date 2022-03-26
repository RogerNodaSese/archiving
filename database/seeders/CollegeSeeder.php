<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colleges')->insert([
            ['id' => 1, 'description' => 'College of Accountancy', 'slug' => 'college-of-accountancy', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 2, 'description' => 'College of Agriculture', 'slug' => 'college-of-agriculture', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 3, 'description' => 'College of Arts and Sciences', 'slug' => 'college-of-arts-and-sciences', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 4, 'description' => 'College of Business Administration', 'slug' => 'college-of-business-administration', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 5, 'description' => 'College of Communication', 'slug' => 'college-of-communication', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 6, 'description' => 'College of Computer Studies', 'slug' => 'college-of-computer-studies', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 7, 'description' => 'College of Criminology', 'slug' => 'college-of-criminology', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 8, 'description' => 'College of Education', 'slug' => 'college-of-education', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 9, 'description' => 'College of Engineering and Architecture', 'slug' => 'college-of-engineering-and-architecture', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 10, 'description' => 'College of International Relations', 'slug' => 'college-of-international-relations', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 11, 'description' => 'College of Medical Technology', 'slug' => 'college-of-medical-technology', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 12, 'description' => 'College of Midwifery', 'slug' => 'college-of-midwifery', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 13, 'description' => 'College of Music', 'slug' => 'college-of-music', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 14, 'description' => 'College of Nursing', 'slug' => 'college-of-nursing', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 15, 'description' => 'College of Physical Therapy', 'slug' => 'college-of-physical-therapy', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 16, 'description' => 'College of Respiratory Therapy', 'slug' => 'college-of-respiratory-therapy', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 18, 'description' => 'College of Medicine', 'slug' => 'college-of-medicine', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 19, 'description' => 'College of Law', 'slug' => 'college-of-law', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['id' => 20, 'description' => 'Graduate School of Education', 'slug' => 'graduate-school-of-education', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        ]);
    }
}
