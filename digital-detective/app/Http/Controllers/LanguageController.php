<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{   
    /**
     * Switch the application's language (locale).
     *
     * This method receives a locale from the request, validates it against a
     * predefined list of supported languages (in this case, 'en' and 'cs'),
     * and then sets the application's locale and stores it in the user's session.
     *
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request, expected to contain a 'locale' input.
     * @return \Illuminate\Http\RedirectResponse
     */
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