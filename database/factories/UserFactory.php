<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake('id_ID')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'role' => 'student',
            'study_program' => 'S1 Sistem Informasi (SI)',
            'nim' => fake()->numerify('21111#####'),
            'is_active' => true,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (): array => [
            'role' => 'admin',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (): array => [
            'email_verified_at' => null,
        ]);
    }
}
