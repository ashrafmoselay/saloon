<?php

namespace App\Listeners;

use App\Bank;
use App\BankTransaction;
use App\ProductStore;
use App\ProductUnit;
use App\Setting;
use App\Transaction;
use App\TresuryTranaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductQuantityReturn
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
            foreach ($details as $item){
                if($item->is_service==1)continue;
                $productStore = isset($productStores[$item->id.$item->pivot->store_id])
                    ?$productStores[$item->id.$item->pivot->store_id]
                    :ProductStore::where('product_id', $item->id)
                        ->where('store_id', $item->pivot->store_id)
                        ->first();
                $orderQty  = $item->pivot->qty;
                $prodstorUnit = $productStore->unit_id;
                $produtUnits =  ProductUnit::where('product_id', $item->id)->get();
                $orderUnit = $produtUnits->where('unit_id', $item->pivot->unit_id)->first();
                $storUnit  = $produtUnits->where('unit_id', $prodstorUnit)->first();

                if ($prodstorUnit != $item->pivot->unit_id) {
                    if ($storUnit->pieces_num < $orderUnit->pieces_num) {
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
                if($order->return_type=='sales'){
                    $productStore->sale_count -= $orderQty;
                }else{
                    $oldCost = $storUnit->cost_price;
                    $oldQty = ($productStore->qty-$productStore->sale_count)?:1;
                    $newQty = $orderQty;
                    $newCost = $item->pivot->price;
                    //$totalNew = ($newQty*$newCost)/$oldQty;
                    //$newAvg = $oldCost-$totalNew;
                    $totalqty = $oldQty-$newQty;
                    if($totalqty) {
                        $productCost = $newCost;
                        if(Setting::findByKey('productCost')=='avg') {
                            $newAvg = (($oldCost * $oldQty) - ($newQty * $newCost)) / ($oldQty - $newQty);
                            $productCost = $newAvg;
                        }
                        $productCost = round($productCost, 2);
                        $item->last_cost = $storUnit->cost_price;
                        $storUnit->cost_price = $productCost;
                        $storUnit->save();
                        $item->avg_cost = round($productCost, 2);
                        $item->save();
                    }
                    $productStore->qty -= $orderQty;
                }

                $productStore->save();

            }
            if($order->is_cash) {
                if($order->return_type=='sales') {
                    $bankId = request('bank_id');
                    if ($bankId) {
                        $trans["bank_id"] = $bankId;
                        $bank = Bank::find($bankId);
                        $trans["op_date"] = date('Y-m-d');
                        $trans["total"] = $bank->balance;
                        $grand = currency($order->return_value, currency()->getUserCurrency(), $bank->currency, $format = false);
                        $note = 'مرتجع مبيعات  | ' . $order->client->name;
                        $trans["due"] = $bank->balance - $grand;
                        $bank->balance -= $grand;
                        $trans["type"] = "1";
                        $trans["note"] = $note;
                        $trans["value"] = $grand;
                        $bank->save();
                        if($order->transaction){
                            $order->transaction()->update($trans);
                        }else{
                            $order->transaction()->create($trans);
                        }
                    }
                  /*  if($order->currency=="EGP"){
                        TresuryTranaction::create([
                            'note' => 'سحب قيمة مرتجعات نقدى الى ' . $order->client->name,
                            'value' => $order->return_value,
                            'type' => 'withdraw',
                            'record_id' => $order->id
                        ]);
                    }else{
                        $bank = Bank::where(['type'=>2,'currency'=>$order->currency])->first();

                        if($bank){
                            $trans["bank_id"] = $bank->id;
                            $trans["note"] = 'سحب قيمة مرتجعات نقدى الى ' . $order->client->name;
                            $trans["record_id"] = $order->id;
                            $trans["op_date"] = date('Y-m-d');
                            $trans["total"] = $bank->balance;
                            $grand = $order->return_value;
                            $trans["due"] = $bank->balance - $grand;
                            $bank->balance -= $grand;
                            $trans["type"] = "1";
                            $trans["value"] = $grand;
                            $bank->save();
                            BankTransaction::create($trans);
                        }
                    }*/
                }else{
                    /*TresuryTranaction::create([
                        'note' => 'ايداع قيمة مرتجعات نقدى من ' . $order->client->name,
                        'value' => $order->return_value,
                        'type' => 'deposite',
                        'record_id' => $order->id
                    ]);*/

                    $bankId = request('bank_id');
                    if ($bankId) {
                        $banktans = $order->transaction()->first();

                        if($banktans){
                            $bank = $banktans->bank;
                            //$bank->balance -= $banktans->getOriginal('value');
                            //$bank->save();
                        }else{
                            $bank = Bank::find($bankId);
                        }
                        //dd('here',$bank->balance);
                        $trans["bank_id"] = $bankId;
                        $bank = Bank::find($bankId);
                        $trans["op_date"] = date('Y-m-d');
                        $trans["total"] = $bank->balance;
                        $grand = currency($order->return_value, currency()->getUserCurrency(), $bank->currency, $format = false);
                        $note = 'مرتجع مشتريات  | ' . $order->client->name;
                        $trans["due"] = $bank->balance + $grand;
                        $bank->balance += $grand;
                        $trans["type"] = "2";
                        $trans["note"] = $note;
                        $trans["value"] = $grand;
                        $bank->save();
                        if($order->transaction){
                            $order->transaction()->update($trans);
                        }else{
                            $order->transaction()->create($trans);
                        }
                    }
                }
            }else{
                $order->client
                    ->transactions()
                    ->create([
                        'value' => -$order->return_value,
                        'note' => ' خصم قيمة مرتجعات من الحساب ',
                        'transaction_type'=>$order->return_type,
                        'record_id' => $order->id
                    ]);

            }
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());

            throw $exception;
        }

    }
}
