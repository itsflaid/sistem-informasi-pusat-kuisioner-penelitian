<?php

namespace App\Http\Requests;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'study_program' => ['required', 'string', Rule::in(DatabaseSeeder::STUDY_PROGRAMS)],
            'nim' => ['required', 'string', 'max:30', 'regex:/^[0-9]+$/'],
        ];
    }
}
