<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'questionnaire_id' => Questionnaire::factory(),
            'type' => 'multiple_choice',
            'text' => fake('id_ID')->sentence().'?',
            'help_text' => null,
            'is_required' => true,
            'sort_order' => 1,
            'settings' => null,
        ];
    }

    public function multipleChoice(): static
    {
        return $this->state(fn (): array => ['type' => 'multiple_choice']);
    }

    public function likert(): static
    {
        return $this->state(fn (): array => ['type' => 'likert']);
    }

    public function shortText(): static
    {
        return $this->state(fn (): array => ['type' => 'short_text']);
    }
}
