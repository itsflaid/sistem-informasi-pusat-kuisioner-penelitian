<?php

namespace App\Models;

use App\Enums\QuestionnaireStatus;
use Database\Factories\QuestionnaireFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id',
    'title',
    'slug',
    'share_code',
    'description',
    'estimated_minutes',
    'target_respondents',
    'deadline_at',
    'status',
    'rejection_reason',
    'closed_reason',
    'reviewed_by',
    'reviewed_at',
    'published_at',
    'closed_at',
])]
class Questionnaire extends \Illuminate\Database\Eloquent\Model
{
    /** @use HasFactory<QuestionnaireFactory> */
    use HasFactory, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('sort_order');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    protected function isOpen(): Attribute
    {
        return Attribute::get(fn (): bool => $this->status === QuestionnaireStatus::Active && $this->deadline_at->isFuture());
    }

    protected function effectiveStatus(): Attribute
    {
        return Attribute::get(function (): QuestionnaireStatus {
            if ($this->status === QuestionnaireStatus::Active && ! $this->deadline_at->isFuture()) {
                return QuestionnaireStatus::Closed;
            }

            return $this->status;
        });
    }

    protected function casts(): array
    {
        return [
            'status' => QuestionnaireStatus::class,
            'deadline_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'published_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }
}
