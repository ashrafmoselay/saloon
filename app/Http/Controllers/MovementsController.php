<?php
namespace App\Http\Controllers;
use App\Movement;
use App\MovementInvoice;
use App\ProductStore;
use App\ProductUnit;
use DB;
use Illuminate\Http\Request;

class MovementsController extends Controller
{

    public function index()
    {
        $movements = MovementInvoice::latest()->get();
        return view('movements.index',compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $movement = new Movement;
        return view('movements.create',compact('movement'));
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
            ->where('store_id', $item->store_from_id)
            ->first();
        $storeTo = ProductStore::where('product_id', $item->product_id)
            ->where('store_id', $item->store_to_id)
            ->first();
        $inputQty = $item->qty;
        $outputQty = $inputQty;
        if ($storeTo && $storeFrom->unit_id != $storeTo->unit_id) {
            $produtUnits =  ProductUnit::where('product_id', $item->product_id)->get();
            $fromUnit = $produtUnits->where('unit_id', $storeFrom->unit_id)->first();
            $toUnit  = $produtUnits->where('unit_id', $storeTo->unit_id)->first();
            $transitUnit  = $produtUnits->where('unit_id', $requiredUnit)->first();
            if ($fromUnit->pieces_num < $transitUnit->pieces_num) {
                $outputQty = $item->qty*$transitUnit->pieces_num;
            } elseif($fromUnit->pieces_num > $transitUnit->pieces_num) {
                $outputQty = $item->qty/$fromUnit->pieces_num;
            }
            if ($fromUnit->pieces_num > $toUnit->pieces_num) {
                $inputQty = $outputQty*$fromUnit->pieces_num;
            } elseif($fromUnit->pieces_num < $toUnit->pieces_num) {
                $inputQty = $outputQty/$toUnit->pieces_num;
            }

        }
        $storeFrom->qty-=$outputQty;
        $storeFrom->save();
        if($storeTo){
            $storeTo->qty+=$inputQty;
            $storeTo->save();
        }else {
            ProductStore::create([
                "product_id" => $item->product_id,
                "store_id" => $item->store_to_id,
                "sale_count" => 0,
                "qty" => $inputQty,
                "unit_id" => $requiredUnit,
            ]);
        }
    }


    public function rollback($movments)
    {
        foreach ($movments as $item) {
            $product_id = $item->product_id;
            $from = $item->store_to_id;
            $to = $item->store_from_id;
            $qty = $item->qty;
            $requiredUnit = $item->unit_id;

            $storeFrom = ProductStore::where('product_id', $product_id)
                ->where('store_id', $from)
                ->first();
            $storeTo = ProductStore::where('product_id', $product_id)
                ->where('store_id', $to)
                ->first();
            $inputQty = $qty;
            $outputQty = $inputQty;
            if ($storeTo && $storeFrom->unit_id != $storeTo->unit_id) {
                $produtUnits = ProductUnit::where('product_id', $item->product_id)->get();
                $fromUnit = $produtUnits->where('unit_id', $storeFrom->unit_id)->first();
                $toUnit = $produtUnits->where('unit_id', $storeTo->unit_id)->first();
                $transitUnit = $produtUnits->where('unit_id', $requiredUnit)->first();
                if ($fromUnit->pieces_num < $transitUnit->pieces_num) {
                    $outputQty = $item->qty * $transitUnit->pieces_num;
                } elseif ($fromUnit->pieces_num > $transitUnit->pieces_num) {
                    $outputQty = $item->qty / $fromUnit->pieces_num;
                }
                if ($fromUnit->pieces_num > $toUnit->pieces_num) {
                    $inputQty = $outputQty * $fromUnit->pieces_num;
                } elseif ($fromUnit->pieces_num < $toUnit->pieces_num) {
                    $inputQty = $outputQty / $toUnit->pieces_num;
                }

            }
            $storeFrom->qty -= $outputQty;
            $storeFrom->save();
            if ($storeTo) {
                $storeTo->qty += $inputQty;
                $storeTo->save();
            } else {
                ProductStore::create([
                    "product_id" => $item->product_id,
                    "store_id" => $item->store_to_id,
                    "sale_count" => 0,
                    "qty" => $inputQty,
                    "unit_id" => $requiredUnit,
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        try {
            //dd($request->all());
            DB::beginTransaction();
            $inputs = $request->except('_token');
//            $inputs["creator_id"] = auth()->user()->id;
            $movment = MovementInvoice::create($inputs);
            activity()
                ->performedOn($movment)
                ->log('اضافة عملية تحويل من مخزن لمخزن');
            foreach ($inputs['product'] as $k=>$val){
                $val['invoice_id'] = $movment->id;
                $item = Movement::create($val);
                $this->move($item,$val['unit_id']);
            }
            DB::commit();
            return redirect(route('movements.index'))->with('alert-success', 'تم إضافة الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('movements.index'))->with('alert-danger', ' حدث خطأ اثناء اضافة اﻷذن '.$e->getMessage());

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
        $movement = MovementInvoice::findOrFail($id);
        $movements = $movement->detailes;
        return view('movements.show',compact('movement','movements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movement = MovementInvoice::findOrFail($id);
        return view('movements.edit',compact('movement'));
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
            //dd($request->all());
            DB::beginTransaction();
            $invoice = MovementInvoice::find($id);
            $inputs = $request->except('_token');
            $this->rollback($invoice->detailes);
            $invoice->detailes()->delete();
            $invoice->update($inputs);
            foreach ($inputs['product'] as $k=>$val){
                $val['invoice_id'] = $id;
                $item = Movement::create($val);
                $this->move($item,$val['unit_id']);
            }
            DB::commit();
            return redirect(route('movements.index'))->with('alert-success', 'تم إضافة الفاتورة بنجاح');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return redirect(route('movements.index'))->with('alert-danger', ' حدث خطأ اثناء اضافة اﻷذن '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movement $movement)
    {
        if($movement->delete()){
            return "done";
        }
        return "failed";

    }


}
