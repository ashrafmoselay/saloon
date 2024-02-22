<?php

namespace App\Http\Controllers;

use App\Combination;
use App\ProductCombination;
use App\ProductStore;
use App\Region;
use App\Setting;
use App\Shipment;
use App\ShipmentDetailes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentsController extends Controller
{
   
    public function __construct()
    {
        view()->composer(['shipments._form'],function($view){
            $prodStatusList = ['تأجيل','مرتجع','مستلم','تدوير','معلقة','تفاوض','مغلق','لا يرد'];
            $view->with([
                'prodStatusList' => $prodStatusList,
            ]);
        });
        parent::__construct();
    }
    public function index()
    {
        $shipments = Shipment::filter()->with('details')->orderBy('id','DESC')->paginate();
        $product_status = request('product_status');
        $result = Shipment::filter()
            ->join('shipment_detailes',function ($join) use($product_status){
                $join->on('shipment_id','=','shipments.id');
                if($product_status){
                    if($product_status[0]!='الكل')
                        $join->wherein('status',$product_status);
                }else{
                    $join->wherein('status',['مستلم','مرتجع','تفاوض']);
                }

            })
            ->select([
                DB::raw('sum( (qty-returned_qty) *  (price-cost) ) as totalProfit'),
                DB::raw('sum( (qty-returned_qty) *  price ) as totalSales'),
                DB::raw('sum( shipping_cost ) as totalShipping'),
                DB::raw('sum( returned_qty ) as totalReturn')
            ])
            ->first()->toArray();
        //dd($result);
        return view('shipments.index',compact('shipments','result'));
    }
    public function report()
    {

        $shipments = ShipmentDetailes::filter();
        return view('shipments.report',compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shipment = new Shipment;
        return view('shipments.create',compact('shipment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->except('_token');
            //dd($inputs);

            $inputs['shipment']['user_id'] = auth()->user()->id;
            $shipment = Shipment::create($inputs['shipment']);
            foreach ($inputs['product'] as $product){
                $product['shipment_id'] = $shipment->id;
                ShipmentDetailes::create($product);
            }
            DB::commit();
            return redirect(route('shipments.show',$shipment->id));
        }catch (\Exception $e) {
            DB::rollback();
            //dd($e->getMessage());
            return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء اضافة الشحنة تأكد من إدخال جميع البيانات بشكل صحيح');
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
        $shipment = Shipment::with('details')->findOrFail($id);
        return view('shipments.show',compact('shipment'));
    }
    public function getInvoices($id)
    {
        $shipment = Shipment::with('details')->findOrFail($id);
        return view('shipments.invoices',compact('shipment'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        return view('shipments.edit',compact('shipment'));
    }

    public function Transfer(Request $request,$prodid)
    {
        if($request->isMethod('POST')){
            $shipment_id = $request->shipment_id;
            ShipmentDetailes::query()->where('id',$prodid)->update(['shipment_id'=>$shipment_id]);
            return back()->with('alert-success','تم نقل الصنف بنجاح');
        }
        return view('shipments.transfer',compact('prodid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        try {
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $shipment->update($inputs['shipment']);
            $shipmentItems = array();
            $settings = Setting::get()->pluck('value','key')->toArray();
            foreach ($inputs['product'] as $product) {
                $product['shipment_id'] = $shipment->id;
                $shipmentItems[] = $product['client_mobile'];
                $details = ShipmentDetailes::where('shipment_id', $shipment->id)
                    ->where('product_id', $product['product_id'])
                    ->where('client_mobile', $product['client_mobile']);
                if(isset($product['combination_id']) && $product['combination_id']){
                    $details->where('combination_id', $product['combination_id']);
                }
                $details = $details->first();
                $oldstatus = '';
                if ($details) {
                    $oldstatus = $details->status;
                    $details->update($product);
                } else {
                    //dd('new');
                    $details = ShipmentDetailes::create($product);
                }
                //dd('here');
                if ($oldstatus != $details->status && in_array($details->status,['مستلم','تفاوض'])) {
                    if(isset($settings['use_color_size_qty']) && $settings['use_color_size_qty']==1){
                        $orderQty = ($details->qty - $details->returned_qty);
                        $checkqty = $settings['can_order_unavilable_qty'] ?: 2;

                        if(in_array($product['combination_id'],['m','l','xl','xxl','xxxl','4xl'])){
                            $listcom = Combination::where('title','like',"%- ".$product['combination_id']."%")->pluck('id')->toArray();
                            $combinationsList = ProductCombination::query()
                                ->where('product_id', $product['product_id'])
                                ->wherein('combination_id',$listcom)
                                ->get();
                            foreach ($combinationsList as $combination){
                                $this->updateCombinationQty($combination,$orderQty,$checkqty,$product);
                            }
                        }else {
                            $combination = ProductCombination::query()
                                ->where('product_id', $product['product_id'])
                                ->where('combination_id', $product['combination_id'])
                                ->first();
                            $this->updateCombinationQty($combination, $orderQty, $checkqty, $product);
                        }
                    }else {
                        $store = ProductStore::query()->where('product_id', $details->product_id)
                            ->where('store_id', $details->store_id)
                            ->first();
                        $checkqty = $settings['can_order_unavilable_qty'] ?: 2;
                        $orderQty = ($details->qty - $details->returned_qty);
                        $avilableQty = ($store->qty - $store->sale_count);
                        if ($orderQty > $avilableQty && $checkqty == 2) {
                            if ($avilableQty < $orderQty) {
                                throw new \Exception(' الكمية غير متاحة ' . $product['product_name']);
                            }
                        }
                        $store->sale_count += $orderQty;
                        $store->save();
                    }
                }
            }
            if(isset($inputs['itemToDelete']) && !empty($inputs['itemToDelete'])) {
                ShipmentDetailes::query()->wherein('id', $inputs['itemToDelete'])
                    ->where('shipment_id', $shipment->id)->delete();
            }
            DB::commit();
            return redirect(route('shipments.show', $shipment->id));
        }catch (\Exception $e) {
            DB::rollback();
            //dd($e->getMessage());
            return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء تعديل الشحنة '.$e->getMessage());
        }
    }
    public function updateCombinationQty($combination,$orderQty,$checkqty,$product){
        if($combination){
            $avilableQty = $combination->qty??0;
            if ($orderQty > $avilableQty && $checkqty == 2) {
                if ($avilableQty < $orderQty) {
                    throw new \Exception(' الكمية غير متاحة ' . $product['product_name']);
                }
            }
            $combination->qty -= $orderQty;
            $combination->sale_counter += $orderQty;
            $combination->save();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateShipping(Request $request,$id)
    {
        $record = Shipment::find($id);
        if($request->isMethod('POST')){
            return back()->with('alert-success','لم يتم الانتهاء منها بعد');
            ShipmentDetailes::query()->where('shipment_id',$id)
                                    ->where('shipping_cost','>',0)
                                    ->update(['shipping_cost'=>$request->new_shipping_cost]);
            return back()->with('alert-success','تم تعديل الشحن للأوردار بنجاح');
        }
        return view('shipments.updateShipping',compact('record'));
    }
    public function prepare(Request $request)
    {
        $noitems = Shipment::query()->doesntHave('details')->delete();
        if($request->isMethod('POST')){
            DB::beginTransaction();
            try{
                $regionList = $request->region_list;
                $regionName = Region::query()->wherein('id', $regionList)->pluck('name')->toArray();
                $regionNameStr = implode(', ',$regionName);
                $listCount = ShipmentDetailes::query()->whereNull('status')
                ->wherein('region_id',$regionList)->count();
                if(!$listCount){
                    return back()->with('alert-danger','لا توجد شحنات مرتبطة بالمحافظات المختاره');
                }
                $shipment = Shipment::query()->create([
                    'shipping_office'=>$regionNameStr,
                    'shipping_status'=>'معلقة',
                    'follow_up_mobile'=>'',
                    'note'=>$regionNameStr,
                    'user_id'=>auth()->user()->id,
                    'created_at'=>date('Y-m-d'),
                ]);
                ShipmentDetailes::query()->whereNull('status')
                ->wherein('region_id',$regionList)
                    ->update(['shipment_id'=>$shipment->id,'status'=>'معلقة']);
                DB::commit();
                return back()->with('alert-success','تم تجهيز شيت الشحن للمحافظات بنجاح');
            }catch(Exception $e){
                DB::rollBack();
                dd($e->getMessage());
                return back()->with('alert-danger','حدث خطأ اثناء تجهز الشحنة للمحافظات المختاره');
            }
        }
        return view('shipments.prepare');
    }


    public function destroy(Shipment $shipment)
    {
        if($shipment->delete()){
            return "done";
        }
        return "failed";
    }
    public function truncateShipments(){
        ShipmentDetailes::query()->truncate();
        Shipment::query()->truncate();
        request()->session()->flash('alert-success', 'تم مسح كل الشحنات بنجاح ');
        return redirect()->route('shipments.index');
    }
}
