<?php

namespace Tests\Feature;

use App\Enums\QuestionnaireStatus;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_review_the_external_link_of_a_pending_questionnaire(): void
    {
        $admin = User::factory()->admin()->create();
        $questionnaire = Questionnaire::factory()->pending()->create(['external_url' => 'https://forms.gle/tautanVerifikasi']);

        $this->actingAs($admin)
            ->get(route('admin.verifications.show', $questionnaire))
            ->assertOk()
            ->assertSee('https://forms.gle/tautanVerifikasi');
    }

    public function test_admin_approves_a_pending_questionnaire(): void
    {
        $admin = User::factory()->admin()->create();
        $questionnaire = Questionnaire::factory()->pending()->create();

        $this->actingAs($admin)
            ->post(route('admin.verifications.approve', $questionnaire))
            ->assertRedirect(route('admin.verifications.index'));

        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'status' => QuestionnaireStatus::Active->value,
            'reviewed_by' => $admin->id,
        ]);
    }

    public function test_admin_rejects_a_pending_questionnaire_with_a_reason(): void
    {
        $admin = User::factory()->admin()->create();
        $questionnaire = Questionnaire::factory()->pending()->create();

        $this->actingAs($admin)
            ->post(route('admin.verifications.reject', $questionnaire), ['rejection_reason' => 'Tautan tidak dapat dibuka.'])
            ->assertRedirect(route('admin.verifications.index'));

        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'status' => QuestionnaireStatus::Rejected->value,
            'rejection_reason' => 'Tautan tidak dapat dibuka.',
        ]);
    }
}
