<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Services\QuestionnaireReportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class QuestionnaireReportController extends Controller
{
    public function show(Request $request, Questionnaire $questionnaire, QuestionnaireReportService $reports): View
    {
        $this->owner($request, $questionnaire);

        return view('questionnaires.report', ['questionnaire' => $questionnaire, 'report' => $reports->build($questionnaire)]);
    }

    public function export(Request $request, Questionnaire $questionnaire): StreamedResponse
    {
        $this->owner($request, $questionnaire);
        $questionnaire->load(['questions', 'responses.answers']);
        return response()->streamDownload(function () use ($questionnaire): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Responden', 'Waktu kirim', ...$questionnaire->questions->map(fn ($question) => $question->text)->all()]);
            foreach ($questionnaire->responses as $index => $response) {
                $answers = $response->answers->keyBy('question_id');
                fputcsv($output, ['Responden '.($index + 1), $response->submitted_at->format('Y-m-d H:i'), ...$questionnaire->questions->map(fn ($question) => $answers->get($question->id)?->value_text ?? $answers->get($question->id)?->value_number ?? $answers->get($question->id)?->option_id ?? '')->all()]);
            }
            fclose($output);
        }, 'rekap-'. $questionnaire->slug.'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function owner(Request $request, Questionnaire $questionnaire): void
    {
        abort_unless($questionnaire->user_id === $request->user()->id, 404);
    }
}
