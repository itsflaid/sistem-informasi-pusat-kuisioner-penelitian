<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'questionnaire_id' => Questionnaire::factory(),
            'user_id' => User::factory(),
            'submitted_at' => now(),
        ];
    }
}
