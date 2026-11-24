<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/_styleguide', function () {
    abort_unless(app()->environment('local'), 404);

    return view('styleguide');
})->name('styleguide');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/questionnaires/{questionnaire}/submit', [QuestionnaireController::class, 'submit'])->name('questionnaires.submit');
    Route::post('/questionnaires/{questionnaire}/close', [QuestionnaireController::class, 'close'])->name('questionnaires.close');
    Route::resource('questionnaires', QuestionnaireController::class)->except('destroy');
});

require __DIR__.'/auth.php';
