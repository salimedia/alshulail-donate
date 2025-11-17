<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, config('app.available_locales'))) {
            abort(400, 'Invalid locale');
        }

        // Store locale in session
        session(['locale' => $locale]);

        return response()->json(['success' => true]);
    }
}
