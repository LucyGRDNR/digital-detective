<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class WelcomeController extends Controller
{
    public function index()
    {
        $stories = Story::all();

        return view('welcome', compact('stories'));
    }

    /**
     * @param string $locale
     * @return RedirectResponse
     */
    public function changeLocale(string $locale): RedirectResponse
    {
        if (!in_array($locale, ['en', 'cs'])) {
            abort(400);
        }

        Session::put("locale", $locale);
        App::setLocale($locale);

        return back();
    }
}
