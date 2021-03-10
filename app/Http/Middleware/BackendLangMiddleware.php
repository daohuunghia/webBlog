<?php

namespace App\Http\Middleware;

use Closure;

class BackendLangMiddleware
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
        if ($lang = $request->session()->get('language')) {
            \App::setLocale($lang);
        }
        return $next($request);
    }
}
