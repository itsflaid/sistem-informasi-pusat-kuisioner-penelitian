<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Response;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', ['pendingCount' => Questionnaire::where('status', 'pending')->count(), 'questionnaireCount' => Questionnaire::count(), 'userCount' => User::count(), 'responseCount' => Response::count()]);
    }
}
