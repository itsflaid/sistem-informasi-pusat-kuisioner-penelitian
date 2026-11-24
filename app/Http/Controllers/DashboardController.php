<?php

namespace App\Http\Controllers;

use App\Enums\QuestionnaireStatus;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $ownQuestionnaires = $user->questionnaires();

        return view('dashboard', [
            'questionnaireCount' => (clone $ownQuestionnaires)->count(),
            'activeQuestionnaireCount' => (clone $ownQuestionnaires)
                ->where('status', QuestionnaireStatus::Active)
                ->where('deadline_at', '>', now())
                ->count(),
            'pendingQuestionnaireCount' => (clone $ownQuestionnaires)
                ->where('status', QuestionnaireStatus::Pending)
                ->count(),
            'recentQuestionnaires' => (clone $ownQuestionnaires)
                ->with('category')
                ->latest()
                ->take(5)
                ->get(),
            'recommendedQuestionnaires' => Questionnaire::query()
                ->with('category')
                ->where('status', QuestionnaireStatus::Active)
                ->where('deadline_at', '>', now())
                ->whereNot('user_id', $user->id)
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}
