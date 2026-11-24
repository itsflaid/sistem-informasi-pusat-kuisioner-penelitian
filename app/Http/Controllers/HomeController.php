<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'activeQuestionnaireCount' => Questionnaire::query()->where('status', 'active')->where('deadline_at', '>', now())->count(),
            'studentCount' => User::query()->where('role', 'student')->count(),
            'activeCategoryCount' => Category::query()->where('is_active', true)->count(),
        ]);
    }
}
