<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['type', 'text', 'help_text', 'is_required', 'sort_order', 'settings'])]
class Question extends \Illuminate\Database\Eloquent\Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('sort_order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'settings' => 'array',
        ];
    }
}
