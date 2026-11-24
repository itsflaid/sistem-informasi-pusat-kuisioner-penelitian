<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'admin'])->default('student')->after('password');
            $table->string('study_program')->nullable()->after('role');
            $table->string('nim')->nullable()->after('study_program');
            $table->boolean('is_active')->default(true)->after('nim');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'study_program', 'nim', 'is_active']);
        });
    }
};
