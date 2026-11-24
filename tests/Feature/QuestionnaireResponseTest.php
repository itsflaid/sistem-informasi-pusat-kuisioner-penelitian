<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Questionnaire;
use App\Models\User;
use Tests\TestCase;

class QuestionnaireResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_submits_one_valid_response_to_active_questionnaire(): void
    {
        $questionnaire = Questionnaire::factory()->active()->create();
        $question = Question::factory()->multipleChoice()->for($questionnaire)->create();
        $option = QuestionOption::factory()->for($question)->create();
        $respondent = User::factory()->create();

        $response = $this->actingAs($respondent)->post(route('fill.store', ['questionnaire' => $questionnaire->slug]), ['answers' => [$question->id => $option->id]]);

        $response->assertRedirect(route('fill.thanks', ['questionnaire' => $questionnaire->slug]));
        $this->assertDatabaseHas('responses', ['questionnaire_id' => $questionnaire->id, 'user_id' => $respondent->id]);
        $this->assertDatabaseHas('answers', ['question_id' => $question->id, 'option_id' => $option->id]);
    }

    public function test_owner_cannot_submit_response_to_own_questionnaire(): void
    {
        $owner = User::factory()->create();
        $questionnaire = Questionnaire::factory()->active()->for($owner)->create();

        $this->actingAs($owner)->post(route('fill.store', ['questionnaire' => $questionnaire->slug]), ['answers' => []])->assertForbidden();
    }
}
