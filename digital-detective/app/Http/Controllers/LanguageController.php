<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switchLanguage(Request $request)
    {
        $locale = $request->input('locale');

        if (in_array($locale, ['en', 'cs'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }

        return Redirect::back();
    }
}