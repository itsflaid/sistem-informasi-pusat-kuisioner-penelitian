<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(Request $request): View
    {
        $responses = $request->user()->responses()->with(['questionnaire.category'])->latest('submitted_at')->paginate(12);

        return view('responses.history', compact('responses'));
    }
}
