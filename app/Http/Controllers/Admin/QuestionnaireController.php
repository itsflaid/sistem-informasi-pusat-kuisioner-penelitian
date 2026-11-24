<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionnaireStatus;
use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $statusFilter = $request->string('status')->toString();

        $questionnaires = Questionnaire::query()
            ->with(['user', 'category'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', '%'.$search.'%')
                        ->orWhereHas('user', fn ($query) => $query->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%'));
                });
            })
            ->when(in_array($statusFilter, array_column(QuestionnaireStatus::cases(), 'value'), true), fn ($query) => $query->where('status', $statusFilter))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.questionnaires.index', [
            'questionnaires' => $questionnaires,
            'search' => $search,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function show(Questionnaire $questionnaire): View
    {
        $questionnaire->load(['user', 'category', 'reviewer']);

        return view('admin.questionnaires.show', compact('questionnaire'));
    }

    public function close(Questionnaire $questionnaire): RedirectResponse
    {
        abort_unless($questionnaire->status === QuestionnaireStatus::Active, 422);

        $questionnaire->update([
            'status' => QuestionnaireStatus::Closed,
            'closed_reason' => 'Ditutup oleh admin.',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Kuesioner berhasil ditutup.');
    }
}
