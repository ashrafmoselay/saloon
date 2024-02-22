<?php

namespace App\Http\Middleware;

use Closure;

class DBConnection
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
        /*if(file_exists('dbConnection.php') && $connection = file_get_contents('dbConnection.php')){
            \DB::purge();
            config()->set('database.default', $connection);
        }*/
        return $next($request);
    }
}
