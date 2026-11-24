<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Services\QuestionnaireReportService;
use App\Services\CsvExporter;
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

    public function export(Request $request, Questionnaire $questionnaire, CsvExporter $exporter): StreamedResponse
    {
        $this->owner($request, $questionnaire);
        return $exporter->questionnaire($questionnaire);
    }

    private function owner(Request $request, Questionnaire $questionnaire): void
    {
        abort_unless($questionnaire->user_id === $request->user()->id, 404);
    }
}
