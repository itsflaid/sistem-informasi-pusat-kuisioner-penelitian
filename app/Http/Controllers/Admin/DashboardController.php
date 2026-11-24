<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionnaireStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'pendingCount' => Questionnaire::query()->where('status', QuestionnaireStatus::Pending)->count(),
            'questionnaireCount' => Questionnaire::query()->count(),
            'activeCount' => Questionnaire::query()
                ->where('status', QuestionnaireStatus::Active)
                ->where('deadline_at', '>', now())
                ->count(),
            'userCount' => User::query()->count(),
            'categoryCount' => Category::query()->count(),
        ]);
    }
}
