<?php

namespace Tests\Feature;

use App\Enums\QuestionnaireStatus;
use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_creates_questionnaire_as_draft(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('questionnaires.store'), $this->payload($category));

        $response->assertRedirect();
        $this->assertDatabaseHas('questionnaires', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Kepuasan Layanan Perpustakaan',
            'status' => QuestionnaireStatus::Draft->value,
        ]);
        $this->assertDatabaseHas('questionnaires', ['external_url' => 'https://forms.gle/contohKuesioner']);
    }

    public function test_owner_submits_draft_questionnaire_for_verification(): void
    {
        $user = User::factory()->create();
        $questionnaire = Questionnaire::factory()->draft()->for($user)->create();

        $response = $this->actingAs($user)->post(route('questionnaires.submit', $questionnaire));

        $response->assertRedirect();
        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'status' => QuestionnaireStatus::Pending->value,
        ]);
    }

    public function test_external_url_must_use_https(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('questionnaires.store'), [
            ...$this->payload($category),
            'external_url' => 'http://forms.gle/contohKuesioner',
        ]);

        $response->assertSessionHasErrors('external_url');
        $this->assertDatabaseMissing('questionnaires', ['user_id' => $user->id]);
    }

    /** @return array<string, mixed> */
    private function payload(Category $category): array
    {
        return [
            'title' => 'Kepuasan Layanan Perpustakaan',
            'category_id' => $category->id,
            'description' => 'Kuesioner untuk mengukur kepuasan mahasiswa terhadap layanan perpustakaan.',
            'estimated_minutes' => 5,
            'target_respondents' => 50,
            'deadline_at' => now()->addDay()->toDateString(),
            'external_url' => 'https://forms.gle/contohKuesioner',
        ];
    }
}
