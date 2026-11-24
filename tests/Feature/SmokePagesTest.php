<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_student_can_open_existing_application_pages(): void
    {
        $student = User::factory()->create();
        $questionnaire = Questionnaire::factory()->for($student)->for(Category::factory())->create();

        foreach ([
            route('dashboard'),
            route('questionnaires.index'),
            route('questionnaires.create'),
            route('questionnaires.show', $questionnaire),
            route('questionnaires.edit', $questionnaire),
        ] as $url) {
            $this->actingAs($student)->get($url)->assertOk();
        }
    }
}
