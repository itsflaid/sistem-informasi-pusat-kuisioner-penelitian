<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/jelajah', [ExploreController::class, 'index'])->name('explore');
Route::get('/k/{questionnaire:slug}', [ExploreController::class, 'show'])->name('public.questionnaires.show');

Route::get('/_styleguide', function () {
    abort_unless(app()->environment('local'), 404);

    return view('styleguide');
})->name('styleguide');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/questionnaires/{questionnaire}/submit', [QuestionnaireController::class, 'submit'])->name('questionnaires.submit');
    Route::post('/questionnaires/{questionnaire}/close', [QuestionnaireController::class, 'close'])->name('questionnaires.close');
    Route::resource('questionnaires', QuestionnaireController::class)->except('destroy');
    Route::get('/k/{questionnaire:slug}/isi', [ResponseController::class, 'create'])->name('fill.show');
    Route::post('/k/{questionnaire:slug}/isi', [ResponseController::class, 'store'])->middleware('throttle:20,1')->name('fill.store');
    Route::get('/k/{questionnaire:slug}/terima-kasih', [ResponseController::class, 'thanks'])->name('fill.thanks');
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history');
});

require __DIR__.'/auth.php';
