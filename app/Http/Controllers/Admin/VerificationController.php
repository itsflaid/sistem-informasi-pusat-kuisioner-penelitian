<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionnaireStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RejectQuestionnaireRequest;
use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function index(): View
    {
        return view('admin.verifications.index', ['questionnaires' => Questionnaire::with(['user', 'category'])->where('status', QuestionnaireStatus::Pending)->latest()->paginate(15)]);
    }

    public function show(Questionnaire $questionnaire): View
    {
        abort_unless($questionnaire->status === QuestionnaireStatus::Pending, 404);
        $questionnaire->load(['user', 'category']);

        return view('admin.verifications.show', compact('questionnaire'));
    }

    public function approve(Questionnaire $questionnaire): RedirectResponse
    {
        abort_unless($questionnaire->status === QuestionnaireStatus::Pending, 422);
        $questionnaire->update(['status' => QuestionnaireStatus::Active, 'reviewed_by' => auth()->id(), 'reviewed_at' => now(), 'published_at' => now()]);

        return redirect()->route('admin.verifications.index')->with('success', 'Kuesioner disetujui.');
    }

    public function reject(RejectQuestionnaireRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        abort_unless($questionnaire->status === QuestionnaireStatus::Pending, 422);
        $questionnaire->update(['status' => QuestionnaireStatus::Rejected, 'rejection_reason' => $request->validated('rejection_reason'), 'reviewed_by' => $request->user()->id, 'reviewed_at' => now()]);

        return redirect()->route('admin.verifications.index')->with('success', 'Kuesioner ditolak.');
    }
}
