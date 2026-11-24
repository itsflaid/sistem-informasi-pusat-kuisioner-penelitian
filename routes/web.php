<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionnaireController as AdminQuestionnaireController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\DashboardController as StudentDashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/jelajah', [ExploreController::class, 'index'])->name('explore');
Route::get('/k/{questionnaire:slug}', [ExploreController::class, 'show'])->name('public.questionnaires.show');

Route::get('/_styleguide', function () {
    abort_unless(app()->environment('local'), 404);

    return view('styleguide');
})->name('styleguide');

Route::get('/dashboard', StudentDashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/panduan', 'public.guide')->name('guide');
Route::view('/privasi', 'public.privacy')->name('privacy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/questionnaires/{questionnaire}/submit', [QuestionnaireController::class, 'submit'])->name('questionnaires.submit');
    Route::post('/questionnaires/{questionnaire}/close', [QuestionnaireController::class, 'close'])->name('questionnaires.close');
    Route::resource('questionnaires', QuestionnaireController::class)->except('destroy');
    Route::get('/k/{questionnaire:slug}/isi', [ResponseController::class, 'create'])->name('fill.show');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifications.index');
    Route::get('/verifikasi/{questionnaire}', [VerificationController::class, 'show'])->name('verifications.show');
    Route::post('/verifikasi/{questionnaire}/setujui', [VerificationController::class, 'approve'])->name('verifications.approve');
    Route::post('/verifikasi/{questionnaire}/tolak', [VerificationController::class, 'reject'])->name('verifications.reject');

    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/pengguna/{user}', [AdminUserController::class, 'update'])->name('users.update');

    Route::get('/kuesioner', [AdminQuestionnaireController::class, 'index'])->name('questionnaires.index');
    Route::get('/kuesioner/{questionnaire}', [AdminQuestionnaireController::class, 'show'])->name('questionnaires.show');
    Route::post('/kuesioner/{questionnaire}/tutup', [AdminQuestionnaireController::class, 'close'])->name('questionnaires.close');
});

require __DIR__.'/auth.php';
