<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Determines the current asset version.
     *
     * @see    https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see    https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        $availableLocales = Config::get('app.available_locales');

        /**
         * @var \Illuminate\Translation\FileLoader
         */
        $loader = $this->app['translation.loader'];

        return array_merge(parent::share($request), [
            'availableLocales' => $availableLocales,
            'locale' => App::getLocale(),
            'language' => $loader->load(App::getLocale(), "*", "*"),
            'user' => Auth::user(),
        ]);
    }
}
