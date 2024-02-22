<?php

namespace App\Http\Middleware;

use Closure;

class Language
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
        $lang = \Session::get ('locale');
        if ($lang != null) \App::setLocale($lang);
            else \Session::put('locale',\App::getLocale() );
        $language = \Session::get('locale', \Config::get('app.locale'));
        if($language)
            \App::setLocale($language);
        return $next($request);
    }
}
