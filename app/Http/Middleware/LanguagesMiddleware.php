<?php

namespace SLBR\Http\Middleware;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Closure;
use SLBR\Models\Language;
use \Cache;

class LanguagesMiddleware
{

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);

        $languages = Cache::rememberForever('languages', function()
        {
            return Language::all()->toArray();
        });
        $locales = array();
        foreach ($languages as $language)
        {
            $locales[] = $language['slug'];
        }

        // if (!in_array($locale, $locales)) {
        //     $segments = $request->segments();
        //     $segments[0] = $this->app->config->get('app.fallback_locale');
        //     $newUrl = implode('/', $segments);
        //     if (array_key_exists('QUERY_STRING', $_SERVER))
        //         $newUrl .= '?'.$_SERVER['QUERY_STRING'];
        //     return $this->redirector->to($newUrl);
        // }

        if (in_array($locale, $locales))
        {
            $this->app->setLocale($locale);
        }

        $request->attributes->add(['languages' => $languages]);
        return $next($request);
    }
}
