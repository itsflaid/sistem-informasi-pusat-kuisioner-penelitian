<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->char('share_code', 8)->unique();
            $table->text('description');
            $table->unsignedTinyInteger('estimated_minutes')->nullable();
            $table->unsignedInteger('target_respondents')->nullable();
            $table->dateTime('deadline_at');
            $table->enum('status', ['draft', 'pending', 'active', 'rejected', 'closed'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->text('closed_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('reviewed_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'deadline_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
