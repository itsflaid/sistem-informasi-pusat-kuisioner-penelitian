<?php

namespace Tests\Feature;

use App\Models\Questionnaire;
use App\Models\Response;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_submit_duplicate_response_for_same_questionnaire(): void
    {
        $user = User::factory()->create();
        $questionnaire = Questionnaire::factory()->create();

        Response::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);

        $this->expectException(QueryException::class);

        Response::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);
    }
}
