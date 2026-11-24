<?php

namespace Tests\Feature;

use App\Enums\QuestionnaireStatus;
use App\Models\Questionnaire;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_the_required_demo_data(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 21);
        $this->assertDatabaseHas('users', ['email' => 'admin@uinsi.ac.id', 'role' => 'admin']);
        $this->assertDatabaseCount('questionnaires', 12);
        $this->assertSame(6, Questionnaire::query()->where('status', QuestionnaireStatus::Active)->count());
        $this->assertSame(12, Questionnaire::query()->whereNotNull('external_url')->count());
        $this->assertSame(20, User::query()->where('role', 'student')->count());
    }
}
