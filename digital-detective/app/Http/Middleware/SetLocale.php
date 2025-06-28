<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $supportedLocales = Config::get('app.supported_locales', []);
        $defaultLocale = Config::get('app.locale', 'en'); 
        $fallbackLocale = Config::get('app.fallback_locale', 'cs');

        $localeToSet = $defaultLocale;

        if (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            $localeToSet = Session::get('locale');
        } else {
            $browserLanguages = $request->getLanguages();

            foreach ($browserLanguages as $browserLang) {
                if (in_array($browserLang, $supportedLocales)) {
                    $localeToSet = $browserLang;
                    break;
                }

                $baseLang = substr($browserLang, 0, 2);
                if (in_array($baseLang, $supportedLocales)) {
                    $localeToSet = $baseLang;
                    break;
                }
            }

            if (!in_array($localeToSet, $supportedLocales)) {
                $localeToSet = $fallbackLocale;
            }
        }

        App::setLocale($localeToSet);
        Session::put('locale', $localeToSet);

        return $next($request);
    }
}