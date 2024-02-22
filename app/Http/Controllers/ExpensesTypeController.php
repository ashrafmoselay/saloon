<?php
namespace App\Http\Controllers;
use App\ExpensesType;
use Illuminate\Http\Request;

class ExpensesTypeController extends Controller
{

    public function index()
    {
        $list = ExpensesType::latest()->get();
        return view('expenses_type.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = new ExpensesType;
        return view('expenses_type.create',compact('type'));
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
        ExpensesType::create($inputs);
        if($request->ajax()){
            $expenses_type = ExpensesType::get();
            return view('expenses_type.dropdown',compact('expenses_type'));
        }
        return redirect(route('expensesType.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = ExpensesType::findOrFail($id);
        return view('expenses_type.show',compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = ExpensesType::find($id);
        return view('expenses_type.edit',compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {

        $type = ExpensesType::find($id);
        $inputs = $request->except('_token');
        $type->update($inputs);
        return redirect(route('expensesType.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = ExpensesType::find($id);
        if($type->delete()){
            return "done";
        }
        return "failed";
    }


}
