<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function create(Request $request, Questionnaire $questionnaire): RedirectResponse
    {
        $this->ensureCanRespond($request, $questionnaire);

        return redirect()->away($questionnaire->external_url);
    }

    private function ensureCanRespond(Request $request, Questionnaire $questionnaire): void
    {
        abort_unless($questionnaire->is_open, 422, 'Kuesioner sudah ditutup atau melewati batas waktu.');
        abort_if($questionnaire->user_id === $request->user()->id, 403, 'Anda tidak dapat mengisi kuesioner milik sendiri.');
    }
}
