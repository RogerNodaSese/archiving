<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Thesis;

class ThesisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Thesis::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'publisher' => 'New Era University',
            'date_of_publication' => $this->faker->date('Y-m'),
            'abstract' => $this->faker->paragraph(5),
            'program_id' => rand(1,53),
            'citation' => 'This is for testing',
            'file_id' => NULL
        ];
    }
}
