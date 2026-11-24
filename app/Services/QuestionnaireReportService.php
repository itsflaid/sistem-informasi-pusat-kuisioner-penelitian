<?php

namespace App\Services;

use App\Models\Questionnaire;
use Illuminate\Support\Collection;

class QuestionnaireReportService
{
    /** @return array<string, mixed> */
    public function build(Questionnaire $questionnaire): array
    {
        $questionnaire->load(['questions.options', 'responses.answers']);
        $responses = $questionnaire->responses;

        return [
            'totalResponses' => $responses->count(),
            'progress' => $questionnaire->target_respondents ? min(100, (int) round($responses->count() / $questionnaire->target_respondents * 100)) : null,
            'dailyResponses' => $responses->groupBy(fn ($response) => $response->submitted_at->toDateString())->map->count(),
            'questions' => $questionnaire->questions->map(fn ($question) => $this->question($question, $responses)),
        ];
    }

    /** @return array<string, mixed> */
    private function question($question, Collection $responses): array
    {
        $answers = $responses->flatMap->answers->where('question_id', $question->id);
        $data = ['question' => $question, 'count' => $answers->count()];
        if ($question->type === 'multiple_choice') {
            $data['options'] = $question->options->map(fn ($option) => ['label' => $option->label, 'count' => $answers->where('option_id', $option->id)->count(), 'percent' => $answers->isEmpty() ? 0 : round($answers->where('option_id', $option->id)->count() / $answers->count() * 100, 1)]);
        } elseif ($question->type === 'likert') {
            $data['distribution'] = collect(range(1, 5))->mapWithKeys(fn ($point) => [$point => $answers->where('value_number', $point)->count()]);
            $data['average'] = $answers->isEmpty() ? null : round($answers->avg('value_number'), 2);
        } else {
            $data['texts'] = $answers->pluck('value_text')->filter()->values();
        }

        return $data;
    }
}
