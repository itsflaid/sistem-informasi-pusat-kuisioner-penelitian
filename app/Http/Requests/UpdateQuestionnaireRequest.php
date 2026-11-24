<?php

namespace App\Http\Requests;

use App\Enums\QuestionnaireStatus;

class UpdateQuestionnaireRequest extends StoreQuestionnaireRequest
{
    public function authorize(): bool
    {
        $questionnaire = $this->route('questionnaire');

        return $this->user()?->id === $questionnaire?->user_id
            && in_array($questionnaire->status, [QuestionnaireStatus::Draft, QuestionnaireStatus::Rejected], true);
    }
}
