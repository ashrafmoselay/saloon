<?php
namespace App\Http\Controllers;
use App\Damage;
use App\ProductStore;
use App\ProductUnit;
use DB;
use Illuminate\Http\Request;

class DamagesController extends Controller
{

    public function index()
    {
        $damages = Damage::filter()->get();
        return view('damages.index',compact('damages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $damage = new Damage;
        return view('damages.create',compact('damage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move($item,$requiredUnit)
    {
        $storeFrom = ProductStore::where('product_id', $item->product_id)
            ->where('store_id', $item->store_id)
            ->first();
        $inputQty = $item->qty;
        $outputQty = $inputQty;
        if ($storeFrom->unit_id != $requiredUnit) {
            $produtUnits =  ProductUnit::where('product_id', $item->product_id)->get();
            $fromUnit = $produtUnits->where('unit_id', $storeFrom->unit_id)->first();
            $transitUnit  = $produtUnits->where('unit_id', $requiredUnit)->first();
            if ($fromUnit->pieces_num < $transitUnit->pieces_num) {
                $outputQty = $item->qty*$transitUnit->pieces_num;
            } elseif($fromUnit->pieces_num > $transitUnit->pieces_num) {
                $outputQty = $item->qty/$fromUnit->pieces_num;
            }
        }
        $storeFrom->qty-=$outputQty;
        $storeFrom->save();
    }


    public function rollback($item)
    {
            $product_id = $item->product_id;
            $from = $item->store_id;
            $qty = $item->qty;
            $requiredUnit = $item->unit_id;

            $storeFrom = ProductStore::where('product_id', $product_id)
                ->where('store_id', $from)
                ->first();
            $inputQty = $qty;
            $outputQty = $inputQty;
            if ($storeFrom->unit_id != $requiredUnit) {
                $produtUnits = ProductUnit::where('product_id', $item->product_id)->get();
                $fromUnit = $produtUnits->where('unit_id', $storeFrom->unit_id)->first();
                $transitUnit = $produtUnits->where('unit_id', $requiredUnit)->first();
                if ($fromUnit->pieces_num < $transitUnit->pieces_num) {
                    $outputQty = $item->qty * $transitUnit->pieces_num;
                } elseif ($fromUnit->pieces_num > $transitUnit->pieces_num) {
                    $outputQty = $item->qty / $fromUnit->pieces_num;
                }
            }
            $storeFrom->qty += $outputQty;
            $storeFrom->save();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->except('_token');
            foreach ($inputs['product'] as $k=>$val){
                $val['creator_id'] = auth()->user()->id;
                $item = Damage::create($val);
                $this->move($item,$val['unit_id']);
            }
            DB::commit();
            return redirect(route('damages.index'))->with('alert-success', 'تم إضافة الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('damages.index'))->with('alert-danger', ' حدث خطأ اثناء اضافة اﻷذن '.$e->getMessage());

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $damage = Damage::findOrFail($id);
        $damages = $damage->detailes;
        return view('damages.show',compact('damage','damages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $damage = Damage::findOrFail($id);
        return view('damages.edit',compact('damage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->except('_token');
            //dd($inputs['product']);
            $invoice = Damage::find($id);
            $invoice->creator_id = auth()->user()->id;
            $this->rollback($invoice);
            foreach ($inputs['product'] as $k=>$val){
                $invoice->update($val);
                $this->move($invoice,$val['unit_id']);
            }
            DB::commit();
            return redirect(route('damages.index'))->with('alert-success', 'تم إضافة الإذن بنجاح');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return redirect(route('damages.index'))->with('alert-danger', ' حدث خطأ اثناء اضافة اﻷذن '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Damage $damage)
    {
        $this->rollback($damage);
        if($damage->delete()){
            return "done";
        }
        return "failed";

    }


}
