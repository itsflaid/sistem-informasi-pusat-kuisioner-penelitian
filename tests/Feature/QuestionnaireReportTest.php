<?php

namespace Tests\Feature;

use App\Models\Questionnaire;
use App\Models\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_downloads_anonymous_csv_export(): void
    {
        $owner = User::factory()->create();
        $respondent = User::factory()->create(['name' => 'Nama Responden', 'email' => 'responden@example.test']);
        $questionnaire = Questionnaire::factory()->for($owner)->create();
        Response::factory()->for($questionnaire)->for($respondent)->create();

        $response = $this->actingAs($owner)->get(route('questionnaires.export', $questionnaire));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $response->assertDontSee('Nama Responden');
        $response->assertDontSee('responden@example.test');
    }
}
