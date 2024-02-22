<?php
namespace App\Http\Controllers;
use App\BankTransaction;
use App\Combination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CombinationController extends Controller
{

    public function index()
    {
        $list = Combination::latest()->get();
        return view('combinations.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = new Combination;
        return view('combinations.create',compact('type'));
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
        if($request->has('deleteprev')){
            DB::table("product_combinations")->truncate();
            Combination::query()->truncate();
        }
        $listComb = $this->getCombinations($inputs['color'],$inputs['size']);
        foreach ($listComb as $com) {
            $myCombinations[]['title'] = implode(' - ', $com);
        }
        Combination::insert($myCombinations);
        return redirect(route('combinations.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = Combination::findOrFail($id);
        return view('combinations.show',compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Combination::find($id);
        return view('combinations.edit',compact('type'));
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

        $type = Combination::find($id);
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
        $type = Combination::find($id);
        if($type->delete()){
            return "done";
        }
        return "failed";
    }


    function getCombinations(...$arrays)
    {
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }

}
