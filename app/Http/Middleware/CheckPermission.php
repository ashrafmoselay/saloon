<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class CheckPermission
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
        try {
            //return $next($request);
            $disableController = [
                'LoginController',
                'RegisterController',
                'ForgotPasswordController',
                'ResetPasswordController',
            ];
            $routeArray = request()->route()->getAction();
            //dd($routeArray);
            if(!isset($routeArray['controller']))return $next($request);
            $controllerAction = class_basename($routeArray['controller']);
            list($controller, $action) = explode('@', $controllerAction);
            if(in_array($controller,$disableController)){
                return $next($request);
            }
            $permissionName = $action . ' ' . $controller;

            $user = auth()->user();

            //dd(auth()->user()->roles()->first()->id);
            /*if($connection = session('mydbcon')){
                \DB::purge();
                config()->set('database.default', $connection);
            }*/

            //dd(strtotime ( date('Y-m-d')) >= env('EXPIRE_DATE'));
            //dd( strtotime ( '+20 day' , strtotime ( date('Y-m-d') )));
            //dd( date('Y-m-d',strtotime ( '+20 day' , strtotime ( date('Y-m-d') ))));
            if(env('EXPIRE_DATE') && strtotime(date('Y-m-d')) >= env('EXPIRE_DATE')){
                throw new \Exception('إنتهت صلاحية النسخة التجربية للتواصل 01061048481');
            }
            if($user) {
               // $user->hasPermissionTo($permissionName);
                if (!$user->hasPermissionTo($permissionName)) throw new PermissionDoesNotExist('ليس لك صلاحية الدخول');
            }

            return $next($request);
        }catch (PermissionDoesNotExist $e){
            if($action=='edit'){
                return response(view('errors.400')->render());
            }
            if(in_array($action,['destroy','cleanDB','closeYear'])){
                return response('failed');
            }

            abort(500, 'Unauthorized action.');
        }catch (\Exception $exception){
            //dd($exception->getMessage());
            abort(440, 'Unauthorized action.');
        }
    }
}
