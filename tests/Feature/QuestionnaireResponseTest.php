<?php

namespace Tests\Feature;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_before_filling(): void
    {
        $questionnaire = Questionnaire::factory()->active()->create();

        $this->get(route('fill.show', $questionnaire))
            ->assertRedirect(route('login'));
    }

    public function test_student_is_redirected_to_the_external_questionnaire_link(): void
    {
        $questionnaire = Questionnaire::factory()->active()->create(['external_url' => 'https://forms.gle/contohKuesioner']);
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('fill.show', $questionnaire))
            ->assertRedirect('https://forms.gle/contohKuesioner');
    }

    public function test_closed_questionnaire_cannot_be_filled(): void
    {
        $questionnaire = Questionnaire::factory()->closed()->create();
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('fill.show', $questionnaire))
            ->assertStatus(422);
    }

    public function test_questionnaire_past_its_deadline_cannot_be_filled(): void
    {
        $questionnaire = Questionnaire::factory()->active()->create(['deadline_at' => now()->subDay()]);
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('fill.show', $questionnaire))
            ->assertStatus(422);
    }

    public function test_owner_cannot_fill_their_own_questionnaire(): void
    {
        $owner = User::factory()->create();
        $questionnaire = Questionnaire::factory()->active()->for($owner)->create();

        $this->actingAs($owner)
            ->get(route('fill.show', $questionnaire))
            ->assertForbidden();
    }
}
