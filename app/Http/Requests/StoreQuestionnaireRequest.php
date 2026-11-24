<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionnaireRequest extends FormRequest
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
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'estimated_minutes' => ['nullable', 'integer', 'min:1', 'max:255'],
            'target_respondents' => ['nullable', 'integer', 'min:1'],
            'deadline_at' => ['required', 'date', 'after:today'],
            'questions' => ['required', 'array', 'min:1', 'max:50'],
            'questions.*.type' => ['required', Rule::in(['multiple_choice', 'likert', 'short_text'])],
            'questions.*.text' => ['required', 'string', 'max:2000'],
            'questions.*.help_text' => ['nullable', 'string', 'max:1000'],
            'questions.*.is_required' => ['nullable', 'boolean'],
            'questions.*.options' => ['nullable', 'array', 'max:20'],
            'questions.*.options.*.label' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            foreach ($this->input('questions', []) as $index => $question) {
                if (($question['type'] ?? null) !== 'multiple_choice') {
                    continue;
                }

                $options = collect($question['options'] ?? [])->pluck('label')->filter(
                    fn (mixed $label): bool => trim((string) $label) !== '',
                );

                if ($options->count() < 2) {
                    $validator->errors()->add("questions.$index.options", 'Pertanyaan pilihan ganda memerlukan minimal dua opsi jawaban.');
                }
            }
        }];
    }
}
