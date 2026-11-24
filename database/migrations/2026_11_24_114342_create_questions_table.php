<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['multiple_choice', 'likert', 'short_text']);
            $table->text('text');
            $table->text('help_text')->nullable();
            $table->boolean('is_required')->default(true);
            $table->unsignedSmallInteger('sort_order');
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index(['questionnaire_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
