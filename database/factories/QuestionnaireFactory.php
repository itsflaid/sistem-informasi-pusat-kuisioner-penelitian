<?php

namespace Database\Factories;

use App\Enums\QuestionnaireStatus;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionnaireFactory extends Factory
{
    public function definition(): array
    {
        $title = fake('id_ID')->sentence(5);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(5),
            'share_code' => Str::upper(Str::random(8)),
            'description' => fake('id_ID')->paragraph(),
            'external_url' => 'https://forms.gle/'.Str::random(12),
            'estimated_minutes' => fake()->numberBetween(5, 15),
            'target_respondents' => fake()->numberBetween(20, 100),
            'deadline_at' => now()->addDays(fake()->numberBetween(7, 30)),
            'status' => QuestionnaireStatus::Active,
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => [
            'status' => QuestionnaireStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (): array => [
            'status' => QuestionnaireStatus::Pending,
            'published_at' => null,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (): array => [
            'status' => QuestionnaireStatus::Active,
            'published_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (): array => [
            'status' => QuestionnaireStatus::Rejected,
            'rejection_reason' => 'Tautan kuesioner tidak valid atau tidak dapat dibuka.',
            'published_at' => null,
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (): array => [
            'status' => QuestionnaireStatus::Closed,
            'closed_reason' => 'Target responden telah tercapai.',
            'closed_at' => now(),
        ]);
    }
}
