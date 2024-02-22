<?php

namespace App\Listeners;

use App\ProductStore;
use App\ProductUnit;
use App\Setting;
use App\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $order = $event->order;
            $productStores = $event->productStores;
            $details = $order->details()->get();
            //dd($details);
            foreach ($details as $item){
                if($item->is_service==1)continue;
                $orderQty  = $item->pivot->qty;

                $productStore = isset($productStores[$item->id.$item->pivot->store_id])
                                    ?$productStores[$item->id.$item->pivot->store_id]
                                    :ProductStore::where('product_id', $item->id)
                                                    ->where('store_id', $item->pivot->store_id)
                                                     ->firstOrCreate(
                                                         [
                                                         'product_id'=> $item->id,
                                                         'store_id'=> $item->pivot->store_id
                                                     ],
                                                     [
                                                         'product_id'=> $item->id,
                                                         'store_id'=> $item->pivot->store_id,
                                                         'qty'=>0,
                                                          'sale_count'=>0,
                                                          "unit_id" => $item->pivot->unit_id
                                                     ]);

                $avilableQty = $productStore->qty-$productStore->sale_count;
                $remainQty = $avilableQty;
                $prodstorUnit = $productStore->unit_id;
                $produtUnits =  ProductUnit::where('product_id', $item->id)->get();
                $orderUnit = $produtUnits->where('unit_id', $item->pivot->unit_id)->first();
                $storUnit  = $produtUnits->where('unit_id', $prodstorUnit)->first();
                if(empty($storUnit)){
//                    dd($item->pivot->product_name,$item->pivot->unit_id,$productStore->unit_id);
                    throw new \Exception(" برجاء مراجعة وحدة المخزن للصنف ".$item->pivot->product_name);
                }
                if ($prodstorUnit != $item->pivot->unit_id) {
                    if($storUnit->pieces_num==0){
                        throw new \Exception(' برجاء مراجعة بيانات الوحدة  '.$storUnit->unit->name." للصنف ".$item->pivot->product_name);
                    }
                    if ($storUnit->pieces_num < $orderUnit->pieces_num) {
                        $avilableQty = $storUnit->pieces_num*$remainQty;
                        $a = $orderUnit->pieces_num/$storUnit->pieces_num;
                        $orderQty = $orderQty*$a;
                    } else {
                        $a = $orderUnit->pieces_num/$storUnit->pieces_num;
                        if($a<1){
                            $orderQty = $orderQty*$a;
                        }else{
                            $orderQty = $orderQty/$a;
                        }
                    }
                }
                if($item->pivot->bounse){
                    $bounse = $item->pivot->bounse;
                    $bounseUnit = $produtUnits->where('unit_id', $item->pivot->bounse_unit_id)->first();
                    if ($prodstorUnit != $item->pivot->bounse_unit_id) {
                        if ($storUnit->pieces_num < $bounseUnit->pieces_num) {
                            $a = $bounseUnit->pieces_num/$storUnit->pieces_num;
                            $bounse = $bounse*$a;
                        } else {
                            $a = $bounseUnit->pieces_num/$storUnit->pieces_num;
                            if($a<1){
                                $bounse = $bounse*$a;
                            }else{
                                $bounse = $bounse/$a;
                            }
                        }
                    }
                    $orderQty  += $bounse;
                }
                if($event->order->status=='delivered'){
                    if($event->order->invoice_type=='sales'){
                        $checkqty = \App\Setting::findByKey('can_order_unavilable_qty')?:2;
                        if ($orderQty > $avilableQty && $checkqty==2) {
                            $availbaleTxt = $avilableQty . " ".$productStore->unit->name;
                            throw new \Exception('الكمية غير متاحة '.$item->pivot->product_name.' فى '.$item->pivot->store_name.' الكمية المتاحة هى '.$availbaleTxt);
                        }

                        $productStore->sale_count += $orderQty;
                       /* if(Setting::findByKey('industrial')==2){
                            foreach ($item->rawMatrial as $raw){
                                $allrwawQty = $orderQty * $raw->pivot->qty;
                                $rawStore = ProductStore::where('product_id', $raw->id)
                                    ->first();
                                $rawavilableQty = $rawStore->qty-$rawStore->sale_count;
                                $checkqty = \App\Setting::findByKey('can_order_unavilable_qty')?:2;
                                if ($allrwawQty > $rawavilableQty && $checkqty==2) {
                                    throw new \Exception('الكمية غير متاحة '.$raw->name);
                                }
                                $rawStore->sale_count += $allrwawQty;
                                $rawStore->save();
                                //dd($rawStore);
                            }
                        }*/
                    }else{
                        $oldCost = $storUnit->cost_price;
                        $productCost = $item->pivot->price;
                        if(Setting::findByKey('productCost')=='avg'){
                            $oldQty =  $item->avilable_qty;
                            //$oldQty = $productStore->qty-$productStore->sale_count;
                            $newQty = $orderQty;
                            $newCost = $item->pivot->price;
                            $allQty = ($oldQty+$newQty)?:1;
                            $avgCost = (((double)$oldQty * (double)$oldCost) + ((double)$newQty * (double)$newCost)) / (double)$allQty;
                            $avgCost = round($avgCost,2);
                            $productCost = abs($avgCost);
                        }


                        if ($storUnit->pieces_num < $orderUnit->pieces_num) {
                            $productCost = $productCost / $orderUnit->pieces_num;
                        } elseif($storUnit->pieces_num > $orderUnit->pieces_num) {
                            $productCost = $productCost * $storUnit->pieces_num;
                        }
                        //dd($storUnit->pieces_num,$orderUnit->pieces_num,$productCost);
//                        if(Setting::findByKey('rounding_up')==1){
//                            $storUnit->cost_price = ceil($productCost);
//                        }else{
                            $storUnit->cost_price = round($productCost,2);

                        //}
                        $storUnit->save();
                        //if(Setting::findByKey('productCost')=='avg') {
                            $this->unitPriceCalaculation($item, $storUnit);
                        //}
                        $productStore->qty += $orderQty;
                        $item->last_cost = $storUnit->cost_price;
                        $item->avg_cost = $productCost;
                        $item->save();
                    }

                    $productStore->save();
                }
            }
            /*if($order->due){
                $granddue = request('due') - $order->due;
                $order->client
                    ->transactions()
                    ->create([
                        'value'=>$granddue,
                        'note'=>' المبلغ المتبقى من الفاتورة رقم '.$order->invoice_number,
                        'transaction_type'=>$order->invoice_type,
                        'record_id'=>$order->id
                    ]);
            }*/
        } catch (\Exception $exception) {
            //\Log::error($exception->getMessage());
            throw $exception;
        }

    }
    public function unitPriceCalaculation($item,$storUnit){
        $productUnit = $item->productUnit()->orderBy('pieces_num')->get();
        $productCost = $storUnit->cost_price;
        foreach ($productUnit as $punit){
            $pivot = $punit->pivot;
            if ($storUnit->pieces_num < $pivot->pieces_num) {
                $newCost = $productCost * $pivot->pieces_num;
                $pivot->cost_price = $newCost;
                $pivot->save();
            } elseif($storUnit->pieces_num > $pivot->pieces_num) {
                $a = $pivot->pieces_num/$storUnit->pieces_num;
                if($a<1){
                    $cost = $storUnit->cost_price*$a;
                }else{
                    $cost = $storUnit->cost_price/$a;
                }
                $pivot->cost_price = $cost;
                $pivot->save();
            }
            if(!$item->is_price_percent) continue;
            //if($storUnit->pieces_num == $punit->pivot->pieces_num) continue;
            //dd($storUnit->pieces_num,$punit->pivot->pieces_num,$punit);

            if ($storUnit->pieces_num < $punit->pivot->pieces_num) {
                $a = $punit->pivot->pieces_num/$storUnit->pieces_num;
                $cost = $storUnit->cost_price*$a;
                $price1 = $storUnit->sale_price*$a;
                $price2 = $storUnit->gomla_price*$a;
                $price3 = $storUnit->half_gomla_price*$a;
                $price4 = $storUnit->gomla_gomla_price*$a;
            } else {
                $a = $punit->pivot->pieces_num/$storUnit->pieces_num;
                if($a<1){
                    $cost = $storUnit->cost_price*$a;
                    $price1 = $storUnit->sale_price*$a;
                    $price2 = $storUnit->gomla_price*$a;
                    $price3 = $storUnit->half_gomla_price*$a;
                    $price4 = $storUnit->gomla_gomla_price*$a;
                }else{
                    $cost = $storUnit->cost_price/$a;
                    $price1 = $storUnit->sale_price/$a;
                    $price2 = $storUnit->gomla_price/$a;
                    $price3 = $storUnit->half_gomla_price/$a;
                    $price4 = $storUnit->gomla_gomla_price/$a;
                }
            }
            $productCost = $cost;
            $categoryPercentage = $item->price_percent?:$item->category->percentage;
            $gomlaPercentage = $item->gomla_price_percent?:$item->category->percentage2;
            if($categoryPercentage && $item->is_price_percent){
                $saleprice = $productCost + ($productCost * ($categoryPercentage/100));
                $saleprice = round($saleprice,2);
                $price1 = $saleprice;
                if($storUnit->gomla_price && $gomlaPercentage)
                    $price2 = $productCost + ($productCost * ($gomlaPercentage/100));
                if($storUnit->gomla_gomla_price && $item->category->percentage3)
                    $price4 = $productCost + ($productCost * ($item->category->percentage3/100));
                if($storUnit->half_gomla_price && $item->category->half_percentage)
                    $price3 = $productCost + ($productCost * ($item->category->half_percentage/100));
            }
            if($productCost > $price1) {
                $diff = $productCost - $price1;
                $price1 += ceil($diff);
            }

            if($productCost > $price2 && $storUnit->gomla_price) {
                $diff = $productCost - $price2;
                $price2 += ceil($diff);
            }

            if($productCost > $price3 && $storUnit->half_gomla_price) {
                $diff = $productCost - $price3;
                $price3 += ceil($diff);
            }

            if($productCost > $price4 && $storUnit->gomla_gomla_price) {
                $diff = $productCost - $price4;
                $price4 += ceil($diff);
            }

//            if(Setting::findByKey('rounding_up')==1){
//                $punit->pivot->cost_price = ceil($cost);
//                $punit->pivot->sale_price = ceil($price1);
//                $punit->pivot->gomla_price = ceil($price2);
//                $punit->pivot->half_gomla_price = ceil($price3);
//                $punit->pivot->gomla_gomla_price = ceil($price4);
//            }else{
                $punit->pivot->cost_price = round($cost,2);
                $punit->pivot->sale_price = round($price1,2);
                $punit->pivot->gomla_price = round($price2,2);
                $punit->pivot->half_gomla_price = round($price3,2);
                $punit->pivot->gomla_gomla_price = round($price4,2);
            //}
            $punit->pivot->save();
        }
    }
}
