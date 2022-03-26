<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Subject::class;

    public function definition()
    {
        return [
            'description' => $this->faker->word()
        ];
    }
}
