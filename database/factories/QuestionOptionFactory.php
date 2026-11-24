<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionOptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'label' => fake('id_ID')->word(),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
