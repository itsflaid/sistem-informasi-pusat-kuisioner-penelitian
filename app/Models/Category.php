<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'is_active'])]
class Category extends \Illuminate\Database\Eloquent\Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
