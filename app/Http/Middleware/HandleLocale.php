<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class HandleLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        $parameters = $request->route()->parameters();

        if (isset($parameters['locale'])) {
            $localeParam = $parameters['locale'];
            if (in_array($localeParam, array_keys(Config::get('app.available_locales')))) {
                $request->session()->put('locale', $localeParam);
                App::setLocale($localeParam);
            }
        } elseif ($request->path() !== '/' && $request->session()->get('locale')) {
            App::setLocale($request->session()->get('locale'));
        }

        return $next($request);
    }
}
