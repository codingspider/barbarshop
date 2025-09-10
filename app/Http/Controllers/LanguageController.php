<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request)
    {
        $lang = $request->lang;
        if (!in_array($lang, ['en', 'ar', 'fr'])) {
            abort(400);
        }
        Session::put('locale', $lang);
        Session::put('language_changed', true);
        return redirect()->back();
    }
}
