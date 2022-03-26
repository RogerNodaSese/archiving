<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thesis;

class ThesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theses = Thesis::factory()->count(1000)->create();

        foreach(Thesis::all() as $thesis)
        {
            $authors = \App\Models\Author::inRandomOrder()->take(rand(1,3))->pluck('id');
            $subjects = \App\Models\Subject::inRandomOrder()->take(rand(1,3))->pluck('id');
            $thesis->authors()->attach($authors);
            $thesis->subjects()->attach($subjects);
        }
    }
}
