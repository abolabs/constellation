<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    public const SESSION_KEY = 'locale';

    public const LOCALES = ['fr', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Session $session */
        $session = $request->session();

        if (! $session->has(self::SESSION_KEY)) {
            $session->put(self::SESSION_KEY, $request->getPreferredLanguage(self::LOCALES));
        }

        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, self::LOCALES)) {
                $session->put(self::SESSION_KEY, $lang);
            }
        }

        app()->setLocale($session->get(self::SESSION_KEY));

        return $next($request);
    }
}
