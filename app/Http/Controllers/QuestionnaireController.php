<?php

namespace App\Http\Controllers;

use App\Enums\QuestionnaireStatus;
use App\Http\Requests\StoreQuestionnaireRequest;
use App\Http\Requests\UpdateQuestionnaireRequest;
use App\Models\Category;
use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function index(Request $request): View
    {
        $questionnaires = $request->user()->questionnaires()->with('category')->latest()->paginate(12);

        return view('questionnaires.index', compact('questionnaires'));
    }

    public function create(): View
    {
        return view('questionnaires.create', ['categories' => $this->categories()]);
    }

    public function store(StoreQuestionnaireRequest $request): RedirectResponse
    {
        $questionnaire = DB::transaction(function () use ($request): Questionnaire {
            $data = $request->validated();
            $data['status'] = QuestionnaireStatus::Draft;
            $data['slug'] = $this->uniqueSlug($data['title']);
            $data['share_code'] = $this->uniqueShareCode();
            $questionnaire = $request->user()->questionnaires()->create($data);

            return $questionnaire;
        });

        return redirect()->route('questionnaires.show', $questionnaire)->with('success', 'Kuesioner berhasil disimpan sebagai draf.');
    }

    public function show(Request $request, Questionnaire $questionnaire): View
    {
        $this->ensureOwner($request, $questionnaire);
        $questionnaire->load('category');

        return view('questionnaires.show', compact('questionnaire'));
    }

    public function edit(Request $request, Questionnaire $questionnaire): View
    {
        $this->ensureEditable($request, $questionnaire);

        return view('questionnaires.edit', ['categories' => $this->categories(), 'questionnaire' => $questionnaire]);
    }

    public function update(UpdateQuestionnaireRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        DB::transaction(function () use ($request, $questionnaire): void {
            $questionnaire->update($request->validated());
            if ($questionnaire->status === QuestionnaireStatus::Rejected) {
                $questionnaire->update(['status' => QuestionnaireStatus::Draft]);
            }
        });

        return redirect()->route('questionnaires.show', $questionnaire)->with('success', 'Draf kuesioner berhasil diperbarui.');
    }

    public function submit(Request $request, Questionnaire $questionnaire): RedirectResponse
    {
        $this->ensureOwner($request, $questionnaire);
        if (! in_array($questionnaire->status, [QuestionnaireStatus::Draft, QuestionnaireStatus::Rejected], true)) {
            return back()->with('error', 'Kuesioner tidak dapat diajukan pada status saat ini.');
        }

        if (! $questionnaire->deadline_at->isFuture()) {
            return back()->with('error', 'Batas waktu harus masih di masa depan saat kuesioner diajukan.');
        }

        $questionnaire->update([
            'status' => QuestionnaireStatus::Pending,
            'rejection_reason' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return back()->with('success', 'Kuesioner telah diajukan untuk diverifikasi.');
    }

    public function close(Request $request, Questionnaire $questionnaire): RedirectResponse
    {
        $this->ensureOwner($request, $questionnaire);
        abort_unless($questionnaire->status === QuestionnaireStatus::Active, 422);
        $questionnaire->update(['status' => QuestionnaireStatus::Closed, 'closed_at' => now()]);

        return back()->with('success', 'Kuesioner berhasil ditutup.');
    }

    private function categories()
    {
        return Category::query()->where('is_active', true)->orderBy('name')->get();
    }

    private function ensureOwner(Request $request, Questionnaire $questionnaire): void
    {
        abort_unless($questionnaire->user_id === $request->user()->id, 404);
    }

    private function ensureEditable(Request $request, Questionnaire $questionnaire): void
    {
        $this->ensureOwner($request, $questionnaire);
        abort_unless(in_array($questionnaire->status, [QuestionnaireStatus::Draft, QuestionnaireStatus::Rejected], true), 422);
    }

    private function uniqueSlug(string $title): string
    {
        do { $slug = Str::slug($title).'-'.Str::lower(Str::random(6)); } while (Questionnaire::query()->where('slug', $slug)->exists());

        return $slug;
    }

    private function uniqueShareCode(): string
    {
        do { $shareCode = Str::upper(Str::random(8)); } while (Questionnaire::query()->where('share_code', $shareCode)->exists());

        return $shareCode;
    }
}
