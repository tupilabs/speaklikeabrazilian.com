<?php

namespace SLBR\Http\Middleware;

use Closure;
use SLBR\Models\Language;

class LanguagesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->attributes->add(['langauges' => 'myValue']);
        return $next($request);
    }
}
