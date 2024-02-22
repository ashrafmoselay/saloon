<?php
namespace App\Http\Controllers;
use App\Setting;
use Illuminate\Http\Request;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    //

	/*public function index()
	{
		 $setting = config('settings');
		 return view('setting.edit',['setting'=>$setting]);

	}

	public function update(Request $request)
	{
		 $inputs = $request->except('_token');
		 $data = var_export($inputs, 1);
		 //dd($data);
         $title = "// generated at ".date("Y-m-d H:i:s");
		 $contents = File::put(config_path().'/settings.php',"<?php\n $title \nreturn $data;");
		 $request->session()->flash('alert-success', 'تم حفظ الأعدادات بنجاح');
		 sleep(3);
		 return back()->withInput();
	}*/



    public function index()
    {
        $setting = Setting::get();
        return view('setting.edit', compact('setting'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method','') as $key => $setting) {
            if($key=='logo' && $request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $filename = 'logo'.'.'.$file->getClientOriginalExtension();
                $file->storePubliclyAs('app/public',$filename);
                $setting = $filename;
            }
            if($key=='signture' && $request->hasFile('signture'))
            {
                $file = $request->file('signture');
                $filename = 'signture'.'.'.$file->getClientOriginalExtension();
                $file->storePubliclyAs('app/public',$filename);
                $setting = $filename;
            }

            Setting::where('key', $key)->update(['value' => $setting]);
        }

        $request->session()->flash('alert-success', trans('front.Modified successfully'));

        return back()->withInput();
    }
    public function deleteLogo()
    {
        Storage::delete(Setting::findByKey('logo'));
        Setting::where('key','logo')->update(['value'=>null]);
        return back();
    }

}
