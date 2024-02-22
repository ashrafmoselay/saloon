<?php
namespace App\Http\Controllers;
use App\Region;
use Illuminate\Http\Request;

class RegionsController extends Controller
{

    public function index()
    {
        $regions = Region::latest()->get();
        return view('regions.index',compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $region = new Region;
        return view('regions.create',compact('region'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only('name');

        Region::firstOrCreate($inputs);
        if($request->ajax()){
            $regions = Region::latest()->get();
            return view('regions.dropdown',compact('regions'));
        }
        return redirect(route('regions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $region = Region::findOrFail($id);
        return view('regions.show',compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        return view('regions.edit',compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $inputs = $request->except('_token');
        $region->update($inputs);
        return redirect(route('regions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        if($region->delete()){
            return "done";
        }
        return "failed";
    }


}
