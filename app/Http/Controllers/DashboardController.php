<?php

namespace App\Http\Controllers;

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
            'receivedResponseCount' => Questionnaire::query()->whereBelongsTo($user)->withCount('responses')->get()->sum('responses_count'),
            'completedQuestionnaireCount' => $user->responses()->distinct('questionnaire_id')->count('questionnaire_id'),
            'recentQuestionnaires' => $ownQuestionnaires->withCount('responses')->latest()->take(5)->get(),
            'recommendedQuestionnaires' => Questionnaire::query()
                ->with(['category', 'user'])
                ->withCount('responses')
                ->where('status', 'active')
                ->where('deadline_at', '>', now())
                ->whereNot('user_id', $user->id)
                ->whereDoesntHave('responses', fn ($query) => $query->whereBelongsTo($user))
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}
