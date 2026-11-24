<?php

namespace App\Services;

use App\Models\Questionnaire;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvExporter
{
    public function questionnaire(Questionnaire $questionnaire): StreamedResponse
    {
        $questionnaire->load(['questions.options', 'responses.answers.option']);

        return response()->streamDownload(function () use ($questionnaire): void {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Responden', 'Waktu kirim', ...$questionnaire->questions->map(fn ($question) => $question->sort_order.'. '.$question->text)->all()], ';');

            foreach ($questionnaire->responses->sortBy(['submitted_at', 'id'])->values() as $index => $response) {
                $answers = $response->answers->keyBy('question_id');
                $values = $questionnaire->questions->map(function ($question) use ($answers): string {
                    $answer = $answers->get($question->id);

                    return $this->safe($answer?->value_text ?? $answer?->value_number ?? $answer?->option?->label ?? '');
                })->all();
                fputcsv($output, ['Responden '.($index + 1), $response->submitted_at->format('Y-m-d H:i'), ...$values], ';');
            }
            fclose($output);
        }, 'rekap-'.$questionnaire->slug.'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function safe(mixed $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+@\-\t\r]/', $value) === 1 ? "'".$value : $value;
    }
}
