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
        $questionnaires = $request->user()->questionnaires()->with('category')->withCount('questions')->latest()->paginate(12);

        return view('questionnaires.index', compact('questionnaires'));
    }

    public function create(): View
    {
        return view('questionnaires.create', ['categories' => $this->categories()]);
    }

    public function store(StoreQuestionnaireRequest $request): RedirectResponse
    {
        $questionnaire = DB::transaction(function () use ($request): Questionnaire {
            $data = $request->safe()->except('questions');
            $data['status'] = QuestionnaireStatus::Draft;
            $data['slug'] = $this->uniqueSlug($data['title']);
            $data['share_code'] = $this->uniqueShareCode();
            $questionnaire = $request->user()->questionnaires()->create($data);
            $this->syncQuestions($questionnaire, $request->validated('questions'));

            return $questionnaire;
        });

        return redirect()->route('questionnaires.show', $questionnaire)->with('success', 'Kuesioner berhasil disimpan sebagai draf.');
    }

    public function show(Request $request, Questionnaire $questionnaire): View
    {
        $this->ensureOwner($request, $questionnaire);
        $questionnaire->load(['category', 'questions.options']);

        return view('questionnaires.show', compact('questionnaire'));
    }

    public function edit(Request $request, Questionnaire $questionnaire): View
    {
        $this->ensureEditable($request, $questionnaire);
        $questionnaire->load('questions.options');

        return view('questionnaires.edit', ['categories' => $this->categories(), 'questionnaire' => $questionnaire]);
    }

    public function update(UpdateQuestionnaireRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        DB::transaction(function () use ($request, $questionnaire): void {
            $questionnaire->update($request->safe()->except('questions'));
            $questionnaire->questions()->delete();
            $this->syncQuestions($questionnaire, $request->validated('questions'));
        });

        return redirect()->route('questionnaires.show', $questionnaire)->with('success', 'Draf kuesioner berhasil diperbarui.');
    }

    public function submit(Request $request, Questionnaire $questionnaire): RedirectResponse
    {
        $this->ensureOwner($request, $questionnaire);
        abort_unless($questionnaire->status === QuestionnaireStatus::Draft, 422);
        $questionnaire->update(['status' => QuestionnaireStatus::Pending]);

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

    /** @param array<int, array<string, mixed>> $questions */
    private function syncQuestions(Questionnaire $questionnaire, array $questions): void
    {
        foreach ($questions as $index => $questionData) {
            $question = $questionnaire->questions()->create([
                'type' => $questionData['type'], 'text' => $questionData['text'], 'help_text' => $questionData['help_text'] ?? null,
                'is_required' => (bool) ($questionData['is_required'] ?? false), 'sort_order' => $index + 1,
            ]);
            $options = $questionData['type'] === 'likert' ? [['label' => '1'], ['label' => '2'], ['label' => '3'], ['label' => '4'], ['label' => '5']] : ($questionData['options'] ?? []);
            foreach ($options as $optionIndex => $option) {
                $label = trim((string) ($option['label'] ?? ''));
                if ($label !== '') {
                    $question->options()->create(['label' => $label, 'sort_order' => $optionIndex + 1]);
                }
            }
        }
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
