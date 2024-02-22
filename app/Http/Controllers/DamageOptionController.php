<?php
namespace App\Http\Controllers;
use App\DamageOption;
use Illuminate\Http\Request;

class DamageOptionController extends Controller
{

    public function index()
    {
        $damageOptions = DamageOption::get();
        return view('damageOptions.index',compact('damageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $damageOption = new DamageOption;
        return view('damageOptions.create',compact('damageOption'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        DamageOption::create($inputs);
        if($request->ajax()){
            $damageOptions = DamageOption::get();
            return view('damageOptions.dropdown',compact('damageOptions'));
        }
        return redirect(route('damageOptions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $damageOption = DamageOption::findOrFail($id);
        return view('damageOptions.show',compact('damageOption'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DamageOption $damageOption)
    {
        return view('damageOptions.edit',compact('damageOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DamageOption $damageOption)
    {
        $inputs = $request->except('_token');
        $damageOption->update($inputs);
        return redirect(route('damageOptions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DamageOption $damageOption)
    {
        if($damageOption->delete()){
            return "done";
        }
        return "failed";
    }


}
