<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
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
            'external_url' => ['required', 'url:https', 'max:2048'],
            'estimated_minutes' => ['nullable', 'integer', 'min:1', 'max:255'],
            'target_respondents' => ['nullable', 'integer', 'min:1'],
            'deadline_at' => ['required', 'date', 'after:today'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('deadline_at')) {
            return;
        }

        $this->merge([
            'deadline_at' => Carbon::parse($this->input('deadline_at'), config('app.timezone'))->endOfDay()->toDateTimeString(),
        ]);
    }
}
