<?php

namespace App\Http\Requests;

use App\Models\Questionnaire;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'answers' => ['array'],
            'answers.*' => ['nullable'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            $questionnaire = $this->route('questionnaire');
            if (! $questionnaire instanceof Questionnaire) return;
            $questionnaire->loadMissing('questions.options');
            foreach ($questionnaire->questions as $question) {
                $answer = $this->input("answers.{$question->id}");
                if ($question->is_required && ($answer === null || $answer === '')) $validator->errors()->add("answers.{$question->id}", 'Pertanyaan ini wajib diisi.');
                if ($answer === null || $answer === '') continue;
                if ($question->type === 'multiple_choice' && ! $question->options->contains('id', (int) $answer)) $validator->errors()->add("answers.{$question->id}", 'Pilihan jawaban tidak valid.');
                if ($question->type === 'likert' && (! filter_var($answer, FILTER_VALIDATE_INT) || (int) $answer < 1 || (int) $answer > 5)) $validator->errors()->add("answers.{$question->id}", 'Nilai skala harus antara 1 dan 5.');
                if ($question->type === 'short_text' && (! is_string($answer) || mb_strlen($answer) > 5000)) $validator->errors()->add("answers.{$question->id}", 'Jawaban isian singkat tidak valid.');
            }
        }];
    }
}
