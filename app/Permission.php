<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Permission extends \Spatie\Permission\Models\Permission
{

    /*
     * Role profile to get value from ntrust config file.
     */
    protected static function getRoutePermission($truncate=false){
    	$role = null;
    	if($truncate){
    		DB::table('permission_role')->truncate();
        	DB::table('permissions')->truncate();
    	}
        $controllers = [];
        $disableController = [
            'LoginController',
            'RegisterController',
            'ForgotPasswordController',
            'ResetPasswordController',
        ];
        foreach (\Route::getRoutes() as $route)
        {
            $action = $route->getAction();

            if (array_key_exists('controller', $action))
            {
                $controllerAction = class_basename($action['controller']);
                list($controller, $method) = explode('@', $controllerAction);
                if(in_array($method,["setLang"]))continue;
                if(in_array($controller,$disableController))continue;
                if(!in_array($controller,$controllers)){
                    $controllers[] = $controller;
                    $methods[$controller] = [];
                }
                if(!in_array($method,$methods[$controller]))
                    $methods[$controller][] = $method;
                $permissionName = $method.' '.$controller;
                \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permissionName]);
            }
        }
        $data['controllers'] = $controllers;
        $data['methods'] = $methods;
        return $data;
    }
}