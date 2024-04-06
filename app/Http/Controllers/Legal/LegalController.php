<?php

namespace App\Http\Controllers\Legal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class LegalController extends Controller
{

    public function showImprint(Request $request)
    {
        $termsFile = Jetstream::localizedMarkdownPath('imprint.md');

        return Inertia::render('Legal/Imprint', [
            'imprint' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }

    public function showPolicy(Request $request)
    {
        $policyFile = Jetstream::localizedMarkdownPath('policy.md');

        return Inertia::render('Legal/PrivacyPolicy', [
            'policy' => Str::markdown(file_get_contents($policyFile)),
        ]);
    }

    public function showTerms(Request $request)
    {
        $termsFile = Jetstream::localizedMarkdownPath('terms.md');

        return Inertia::render('Legal/TermsOfService', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
