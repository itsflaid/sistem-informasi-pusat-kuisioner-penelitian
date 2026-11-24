<?php

namespace Tests\Feature;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_is_redirected_to_the_external_questionnaire_link(): void
    {
        $questionnaire = Questionnaire::factory()->active()->create(['external_url' => 'https://forms.gle/contohKuesioner']);
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('fill.show', $questionnaire->slug))
            ->assertRedirect('https://forms.gle/contohKuesioner');
    }
}
