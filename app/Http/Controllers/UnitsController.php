<?php
namespace App\Http\Controllers;
use App\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{

    public function index()
    {
        $units = Unit::get();
        return view('units.index',compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = new Unit;
        return view('units.create',compact('unit'));
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
        Unit::create($inputs);
        if($request->ajax()){
            $units = Unit::get();
            return view('units.dropdown',compact('units'));
        }
        return redirect(route('units.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::findOrFail($id);
        return view('units.show',compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return view('units.edit',compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $inputs = $request->except('_token');
        $unit->update($inputs);
        return redirect(route('units.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        if($unit->delete()){
            return "done";
        }
        return "failed";
    }


}
