<?php
namespace App\Http\Controllers;
use App\TresuryTranaction;
use Illuminate\Http\Request;

class TresuryTranactionsController extends Controller
{

    public function index()
    {
        $transactions = TresuryTranaction::latest()->get();
        return view('tresury_tranactions.index',compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tresuryTranaction = new TresuryTranaction;
        return view('tresury_tranactions.create',compact('tresuryTranaction'));
    }

    /**
     * TresuryTranaction a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        TresuryTranaction::create($inputs);
        return redirect(route('tresuryTranactions.index'))->with('alert-success', trans('front.Successfully added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tranaction = TresuryTranaction::findOrFail($id);
        return view('tresury_tranactions.show',compact('tranaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TresuryTranaction $tresuryTranaction)
    {
        return view('tresury_tranactions.edit',compact('tresuryTranaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TresuryTranaction $tresuryTranaction)
    {
        $inputs = $request->except('_token');
        $tresuryTranaction->update($inputs);
        return redirect(route('tresuryTranactions.index'))->with('alert-success', trans('front.Modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TresuryTranaction $tresuryTranaction)
    {
        if($tresuryTranaction->delete()){
            return "done";
        }
        return "failed";
    }


}
