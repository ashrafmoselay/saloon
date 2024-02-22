<?php

namespace App\Http\Controllers;

use App\CalanderPayment;
use App\Person;
use App\Setting;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        ini_set('memory_limit', '1024M');
        /*Artisan::call('migrate');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');*/
        //die("done");
        //Artisan::call('migrate');
        $settings = Setting::get()->pluck('value','key')->toArray();
        $today = date('Y-m-d');
//        if (Cache::has('notifications')) {
//            $notifications = Cache::get('notifications');
//        }else{
        $records = Person::where('remember_review_balance',1)
            ->where(function($q)use($today){
                $q->whereRaw("DATE(remember_date) <= '{$today}'")
                    ->orwhereNull('remember_date');
            })->get();
            //dd($records);
        $instalments = CalanderPayment::query();
        $instalments->where('is_paid',0);
        $instalments->whereRaw("strftime('%Y-%m-%d',date) = '{$today}'"); //SQLLITE
        // if(env('DB_CONNECTION')=='sqlite'){
        //     $instalments->whereRaw("strftime('%Y-%m-%d',date) = '{$today}'"); //SQLLITE
        // }else{
        //     $instalments->whereRaw("DATE_FORMAT('date', '%Y-%m-%d')= '{$today}'"); //MySQL
        // }
        $instalments = $instalments->latest()->get();
        $notifications = (string) view('layouts.partial.notifications',['records'=>$records,'instalments'=>$instalments]);
        view()->share([
            'settings'=> $settings,
            'notifications'=>$notifications
        ]);

    }

    public function setLang($language='en'){
        Session::put('locale',$language );
        //App::setLocale($language);
        return \Redirect::back();
    }

}
