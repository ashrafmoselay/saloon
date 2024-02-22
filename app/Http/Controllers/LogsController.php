<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Database\Eloquent\Builder;

class LogsController extends Controller
{
    public function index()
    {
        //config(['activitylog.subject_returns_soft_deleted_models' => true]);
        $query = Activity::with('subject','causer')
            ->inLog('default')
            ->orderBy('id','desc');
        $logs = $query->filter(\request()->all())->paginate(20);
        return view('logs.index',compact('logs'));
    }

}
