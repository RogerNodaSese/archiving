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
            ["description" => "Bachelor of Science in Accountancy","slug" => "bachelor-of-science-in-accountancy","college_id" => 1 ],
	        ["description" => "Bachelor of Science in Accounting Information System","slug" => "bachelor-of-science-in-accounting-information-system","college_id" => 1 ],
	        ["description" => "Bachelor of Arts in Economics","slug" => "bachelor-of-arts-in-economics","college_id" => 3 ],
	        ["description" => "Bachelor of Science in Psychology","slug" => "bachelor-of-science-in-psychology","college_id" => 3 ],
	        ["description" => "Bachelor of Arts in Public Administration","slug" => "bachelor-of-arts-in-public-administration","college_id" => 3 ],
	        ["description" => "Bachelor of Arts in Public Administration","slug" => "bachelor-of-arts-in-public-administration","college_id" => 3 ],
	        ["description" => "AB Political Science","slug" => "ab-political-science","college_id" => 3 ],
	        ["description" => "Bachelor of Science in Real Estate Management","slug" => "bachelor-of-science-in-real-estate-management","college_id" => 4 ],
	        ["description" => "Bachelor of Science in Business Administration major in Marketing Management","slug" => "bachelor-of-science-in-business-administration-major-in-marketing-management","college_id" => 4 ],
	        ["description" => "Bachelor of Science in Business Administration major in Human Resource Development and Management","slug" => "bachelor-of-science-in-business-administration-major-in-human-resource-development-and-management","college_id" => 4 ],
	        ["description" => "Bachelor of Science in Business Administration major in Legal Management","slug" => "bachelor-of-science-in-business-administration-major-in-legal-management","college_id" => 4 ],
	        ["description" => "Bachelor of Science in Entrepreneurship","slug" => "bachelor-of-science-in-entrepreneurship","college_id" => 4 ],
	        ["description" => "Bachelor of Science in Business Administration major in Financial Management","slug" => "bachelor-of-science-in-business-administration-major-in-financial-management","college_id" => 4 ],
	        ["description" => "Bachelor of Arts in Communication","slug" => "bachelor-of-arts-in-communication","college_id" => 5 ],
	        ["description" => "Bachelor of Arts in Broadcasting","slug" => "bachelor-of-arts-in-broadcasting","college_id" => 5 ],
	        ["description" => "Bachelor of Arts in Journalism","slug" => "bachelor-of-arts-in-journalism","college_id" => 5 ],
	        ["description" => "Bachelor of Library Information Science","slug" => "bachelor-of-library-information-science","college_id" => 6 ],
	        ["description" => "Bachelor of Science in Information Technology","slug" => "bachelor-of-science-in-information-technology","college_id" => 6 ],
	        ["description" => "Bachelor of Science in Information Systems","slug" => "bachelor-of-science-in-information-systems","college_id" => 6 ],
	        ["description" => "Bachelor of Science in Entertainment and Multimedia Computing major in Game Development","slug" => "bachelor-of-science-in-entertainment-and-multimedia-computing-major-in-game-development","college_id" => 6 ],
	        ["description" => "Bachelor of Science in Entertainment and Multimedia Computing major in Digital Animation","slug" => "bachelor-of-science-in-entertainment-and-multimedia-computing-major-in-digital-animation","college_id" => 6 ],
	        ["description" => "Bachelor of Science in Computer Science","slug" => "bachelor-of-science-in-computer-science","college_id" => 6 ],
	        ["description" => "Bachelor of Criminology","slug" => "bachelor-of-criminology","college_id" => 7 ],
	        ["description" => "Bachelor of Secondary Education Major in Filipino","slug" => "bachelor-of-secondary-education-major-in-filipino","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in Mathematics","slug" => "bachelor-of-secondary-education-major-in-mathematics","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in Biological Sciences","slug" => "bachelor-of-secondary-education-major-in-biological-sciences","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in Physical Sciences","slug" => "bachelor-of-secondary-education-major-in-physical-sciences","college_id" => 8 ],
	        ["description" => "Bachelor of Elementary Education specialization in General Sciences","slug" => "bachelor-of-elementary-education-specialization-in-general-sciences","college_id" => 8 ],
	        ["description" => "Bachelor of Elementary Education specialization in Special Education","slug" => "bachelor-of-elementary-education-specialization-in-special-education","college_id" => 8 ],
	        ["description" => "Bachelor of Elementary Education specialization in Content Courses","slug" => "bachelor-of-elementary-education-specialization-in-content-courses","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in Technology and Livelihood Education","slug" => "bachelor-of-secondary-education-major-in-technology-and-livelihood-education","college_id" => 8 ],
	        ["description" => "Bachelor of Elementary Education specialization in Pre-School Education","slug" => "bachelor-of-elementary-education-specialization-in-pre-school-education","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in MAPEH","slug" => "bachelor-of-secondary-education-major-in-mapeh","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in English","slug" => "bachelor-of-secondary-education-major-in-english","college_id" => 8 ],
	        ["description" => "Bachelor of Secondary Education Major in Social Studies","slug" => "bachelor-of-secondary-education-major-in-social-studies","college_id" => 8 ],
	        ["description" => "Bachelor of Science in Astronomy","slug" => "bachelor-of-science-in-astronomy","college_id" => 9 ],
	        ["description" => "Bachelor of Science in Industrial Engineering","slug" => "bachelor-of-science-in-industrial-engineering","college_id" => 9 ],
	        ["description" => "Bachelor of Science in Mechanical Engineering","slug" => "bachelor-of-science-in-mechanical-engineering","college_id" => 9 ],
	        ["description" => "Bachelor of Science in Architecture","slug" => "bachelor-of-science-in-architecture","college_id" => 9 ],
	        ["description" => "Bachelor of Science in Electronics Engineering","slug" => "bachelor-of-science-in-electronics-engineering","college_id" => 9 ],
	        ["description" => "Bachelor of Science in Electrical Engineering","slug" => "bachelor-of-science-in-electrical-engineering","college_id" => 9 ],
	        ["description" => "Bachelor of Science in Civil Engineering","slug" => "bachelor-of-science-in-civil-engineering","college_id" => 9 ],
	        ["description" => "Bachelor of Arts in Foreign Service","slug" => "bachelor-of-arts-in-foreign-service","college_id" => 10 ],
	        ["description" => "Bachelor of Science in Medical Technology","slug" => "bachelor-of-science-in-medical-technology","college_id" => 11 ],
	        ["description" => "Diploma in Midwifery","slug" => "diploma-in-midwifery","college_id" => 12 ],
	        ["description" => "Music Prepartory and Extended Studies","slug" => "music-prepartory-and-extended-studies","college_id" => 13 ],
	        ["description" => "Bachelor of Music Major in Choral Conducting","slug" => "bachelor-of-music-major-in-choral-conducting","college_id" => 13 ],
	        ["description" => "Bachelor of Music Major in Piano","slug" => "bachelor-of-music-major-in-piano","college_id" => 13 ],
	        ["description" => "Bachelor of Music Major in Voice","slug" => "bachelor-of-music-major-in-voice","college_id" => 13 ],
	        ["description" => "Bachelor of Music Major in Music Education","slug" => "bachelor-of-music-major-in-music-education","college_id" => 13 ],
	        ["description" => "Bachelor of Science in Nursing","slug" => "bachelor-of-science-in-nursing","college_id" => 14 ],
	        ["description" => "Bachelor of Science in Physical Therapy","slug" => "bachelor-of-science-in-physical-therapy","college_id" => 15 ],
	        ["description" => "Bachelor of Science in Respiratory Therapy","slug" => "bachelor-of-science-in-respiratory-therapy","college_id" => 16 ],
        ]);
    }
}
