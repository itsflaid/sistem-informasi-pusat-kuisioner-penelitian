<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'option_id' => null,
            'value_number' => null,
            'value_text' => fake('id_ID')->word(),
        ];
    }
}
