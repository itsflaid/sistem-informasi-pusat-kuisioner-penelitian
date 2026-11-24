<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResponseRequest;
use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResponseController extends Controller
{
    public function create(Request $request, Questionnaire $questionnaire): View
    {
        $this->ensureCanRespond($request, $questionnaire);
        $questionnaire->load('questions.options');

        return view('responses.create', compact('questionnaire'));
    }

    public function store(StoreResponseRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        $this->ensureCanRespond($request, $questionnaire);
        $questionnaire->load('questions.options');

        DB::transaction(function () use ($request, $questionnaire): void {
            $response = $questionnaire->responses()->create(['user_id' => $request->user()->id, 'submitted_at' => now()]);
            foreach ($questionnaire->questions as $question) {
                $answer = $request->validated('answers')[$question->id] ?? null;
                if ($answer === null || $answer === '') continue;
                $attributes = ['question_id' => $question->id];
                if ($question->type === 'multiple_choice') $attributes['option_id'] = $answer;
                elseif ($question->type === 'likert') $attributes['value_number'] = $answer;
                else $attributes['value_text'] = $answer;
                $response->answers()->create($attributes);
            }
        });

        return redirect()->route('fill.thanks', ['questionnaire' => $questionnaire->slug]);
    }

    public function thanks(Questionnaire $questionnaire): View
    {
        return view('responses.thanks', compact('questionnaire'));
    }

    private function ensureCanRespond(Request $request, Questionnaire $questionnaire): void
    {
        abort_unless($questionnaire->is_open, 422, 'Kuesioner sudah ditutup atau melewati batas waktu.');
        abort_if($questionnaire->user_id === $request->user()->id, 403, 'Anda tidak dapat mengisi kuesioner milik sendiri.');
        abort_if($questionnaire->responses()->whereBelongsTo($request->user())->exists(), 422, 'Anda sudah mengisi kuesioner ini.');
    }
}
