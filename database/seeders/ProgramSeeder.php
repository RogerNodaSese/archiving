<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programs')->insert([
            [
                "description" => "Bachelor of Library Information Science",
                "slug" => "blis",
                "college_id" => 1
            ],
            [
                "description" => "Bachelor of Science in Information Technology",
                "slug" => "bsit",
                "college_id" => 1
            ],
            [
                "description" => "Bachelor of Science in Information Systems",
                "slug" => "bsis",
                "college_id" => 1
            ],
            [
                "description" => "Bachelor of Science in Entertainment and Multimedia Computing major in Game Development",
                "slug" => "bsemcgd",
                "college_id" => 1
            ],
            [
                "description" => "Bachelor of Science in Entertainment and Multimedia Computing major in Digital Animation",
                "slug" => "bsemcda",
                "college_id" => 1
            ],
            [
                "description" => "Bachelor of Science in Computer Science",
                "slug" => "bscs",
                "college_id" => 1
            ],
            [
                "description" => "Bachelor of Science in Astronomy",
                "slug" => "bs-astronomy",
                "college_id" => 2
            ],
            [
                "description" => "Bachelor of Science in Industrial Engineering",
                "slug" => "bs-industrial-engineering",
                "college_id" => 2
            ],
            [
                "description" => "Bachelor of Science in Mechanical Engineering",
                "slug" => "bsme",
                "college_id" => 2
            ],
            [
                "description" => "Bachelor of Science in Architecture",
                "slug" => "bs-architecture",
                "college_id" => 2
            ],
            [
                "description" => "Bachelor of Science in Electronics Engineering",
                "slug" => "bs-electronics-engineering",
                "college_id" => 2
            ],
            [
                "description" => "Bachelor of Science in Electrical Engineering",
                "slug" => "bs-electrical-engineering",
                "college_id" => 2
            ],
            [
                "description" => "Bachelor of Science in Civil Engineering",
                "slug" => "bs-civil-engineering",
                "college_id" => 2
            ],
        ]);
    }
}
