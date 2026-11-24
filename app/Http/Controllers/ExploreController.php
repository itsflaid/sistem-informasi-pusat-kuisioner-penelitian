<?php

namespace App\Http\Controllers;

use App\Enums\QuestionnaireStatus;
use App\Models\Category;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    public function index(Request $request): View
    {
        $query = Questionnaire::query()->with('category')->where('status', QuestionnaireStatus::Active)->where('deadline_at', '>', now());
        $query->when($request->string('q')->trim()->isNotEmpty(), fn ($q) => $q->where('title', 'like', '%'.$request->string('q')->trim().'%'));
        $query->when($request->integer('kategori'), fn ($q, $categoryId) => $q->where('category_id', $categoryId));
        $query->when($request->string('prodi')->trim()->isNotEmpty(), fn ($q) => $q->whereHas('user', fn ($user) => $user->where('study_program', $request->string('prodi')->trim())));
        match ($request->string('urut')->toString()) {
            'deadline' => $query->orderBy('deadline_at'),
            default => $query->latest(),
        };

        return view('public.explore', ['questionnaires' => $query->paginate(12)->withQueryString(), 'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(), 'studyPrograms' => Questionnaire::query()->where('status', QuestionnaireStatus::Active)->with('user:id,study_program')->get()->pluck('user.study_program')->filter()->unique()->sort()->values()]);
    }

    public function show(Questionnaire $questionnaire): View
    {
        abort_unless($questionnaire->is_open, 404);
        $questionnaire->load(['category', 'user']);

        return view('public.questionnaire', compact('questionnaire'));
    }
}
