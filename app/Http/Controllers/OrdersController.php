<?php

namespace App\Http\Controllers;

use App\Area;
use App\Bank;
use App\BankTransaction;
use App\CalanderPayment;
use App\Category;
use App\Events\OrderCreated;
use App\Expense;
use App\Government;
use App\OrderDetail;
use App\Person;
use App\Product;
use App\Order;
use App\ProductStore;
use App\ProductUnit;
use App\Setting;
use App\Transaction;
use App\UserPoint;
use App\WorkOrder;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{

    public function index($type = 'sales')
    {
        $orders = []; //Order::where('invoice_type',$type)->latest()->get();
        return view('orders.index', compact('orders', 'type'));
    }
    public function report()
    {
        if (!request()->ajax()) {
            return view('reports.orders');
        } else {
            return $this->getData('sales');
        }
    }
    

    public function purchasereport()
    {
        if (!request()->ajax()) {
            return view('reports.purchase');
        } else {
            return $this->getData('purchase');
        }
    }


    /*  public function getSales(){
          return $this->index('sales');
      }*/
    public function getSales(Request $request)
    {
        // $orders = Order::where('invoice_type','sales')
        // ->whereRaw(DB::raw('CAST(invoice_number AS INT) >= 120')  )
        //                 ->orderBy('id','ASC')->get();
        // $i = 120;
        // foreach($orders as $order){
        //     $order->invoice_number = $i;
        //     $i++;
        //     $order->save();
        // }
        ini_set('memory_limit', -1);

        if (!$request->ajax()) {
            $type = 'sales';
            $urlRoute = route('orders.index');
            return view('orders.index', compact('type', 'urlRoute'));
        } else {
            return $this->getData('sales');
        }
    }
    public function getPurchases(Request $request)
    {
        //return $this->index('purchase');
        if (!$request->ajax()) {
            $type = 'purchase';
            $urlRoute = route('purchases.index');

            return view('orders.index', compact('type', 'urlRoute'));
        } else {
            return $this->getData('purchase');
        }
    }
    public function setOrderProfit($order)
    {
        $order->profit = $order->order_profit;
        $order->save();
    }
    public function getData($type)
    {
        ini_set('memory_limit', -1);
        //Order::query()->update(['bank_id'=>1]);
        $userTreasury = auth()->user()->treasury->id;
        $list = Order::where('invoice_type', $type)
            ->where('bank_id', $userTreasury)
            ->orderBy('id', 'DESC');
        //->with('client','saleMan','creator');
        if (!empty(request('client_id'))) {
            $list->where('client_id', request('client_id'));
        }

        if (!empty(request('priceType'))) {
            $list->where('priceType', request('priceType'));
        }
        $from = request('fromdate');
        $to = request('todate');
        if (!empty($from)) {
            $list->whereRaw("DATE(invoice_date) >= '{$from}'");
        }
        if (!empty($to)) {
            $list->whereRaw("DATE(invoice_date) <= '{$to}'");
        }
        $currentUser = auth()->user();

        $datatable = DataTables::of($list)
            ->addColumn('total', function ($order) {
                $total = $order->total;
                return currency($total, $order->currency, $order->currency, $format = true);
            })
            ->addColumn('totalbefore', function ($order) {
                return round(($order->total - $order->tax_value), 2);
            })
            ->addColumn('tax_value', function ($order) {
                return round($order->tax_value, 2);
            })
            ->addColumn('saleperson', function ($order) {
                return optional($order->saleMan)->name;
            })
            ->addColumn('clientname', function ($order) {
                return '<a href = "' . route('persons.show', $order->client_id) . '" ><i class="fa fa-user" ></i > ' . optional($order->client)->name . '</a>';
            })
            ->addColumn('creator', function ($order) {
                return optional($order->creator)->name;
            })
            ->addColumn('paid', function ($order) {
                return currency($order->getOriginal('paid'), $order->currency, $order->currency, $format = true);
            })
            ->addColumn('due', function ($order) {
                $due = $order->due;
                return currency($due, $order->currency, $order->currency, $format = true);
            })
            ->addColumn('dicount_value', function ($order) {
                return $order->dicount_value;
            })
            ->addColumn('priceType', function ($order) {
                return trans('front.' . $order->priceType);
            })
            ->addColumn('priceType', function ($order) {
                $priceType = $order->priceType;
                return trans("front.$priceType");
            })
            ->addColumn('payment_type', function ($order) {
                $payment = $order->payment_type;
                if ($order->payment_type == 'cash') {
                    $payment = trans("front.$payment");
                } elseif ($order->payment_type == 'delayed') {
                    $payment = trans("front.$payment");
                } elseif ($order->payment_type == 'visa') {
                    $payment = trans("front.$payment");
                } else {
                    $payment = trans("front.$payment");
                    /*if($order->getOriginal('due')>0){
                        $payment = trans("front.$payment");
                    }*/
                    if ((double) $order->commision) {
                        $com = currency($order->commision, $order->currency, $order->currency, $format = true);
                        $payment .= '<a style="margin: 5px;" class="btn btn-warning"> ' . $com . '</a>';
                    }
                }
                return $payment;
            })
            ->addColumn('status', function ($order) {
                $btn = '';
                if ($order->status == 'delivered') {
                    $btn .= '<button href = "#" type = "button" class="btn btn-sm btn-success" ><i class="fa  fa-check" ></i ></button >';
                } else {
                    $btn .= '<a href = "' . route('orders.changeStatus', $order) . '" type = "button" class="btn btn-sm btn-danger changeStatus" ><i class="fa fa-times" ></i ></a>';
                }
                if ($order->is_withdrawable == 1) {
                    $btn .= '<div class="bg-yellow" style="padding: 5px;"> مسحوبات </div>';
                }
                return $btn;
            })
            ->addColumn('actions', function ($order) use ($currentUser) {
                $btn = "";
                if (env('turbo_authentication_key') && !$order->is_shipped) {
                    $btn .= ' <a data-toggle="modal" data-target="#myModalShipment" href="' . route('createTurpoShipment', $order) . '" class="btn btn-info btn-xs">
                        <i class="fa fa-truck fa-fw" aria-hidden="true"></i>
                    </a> ';
                }
                if ($currentUser->can('edit OrdersController')) {
                    $btn .= '<a href="' . route('orders.edit', $order) . '" class="btn btn-primary btn-xs">
                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                    </a>';
                }
                if ($currentUser->can('show OrdersController')) {
                    $btn .= ' <a data-toggle="modal" data-target="#addPersonModal" href="' . route('orders.show', $order) . '" class="btn btn-warning btn-xs">
                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                </a> <a class=" btn btn-success btn-xs print-window" href="' . route('orders.getPrint', $order->id) . '" target="_blank"
                role="button">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                            </a>';
                }
                if ($currentUser->can('destroy OrdersController')) {
                    $btn .= ' <a class="btn btn-xs btn-danger remove-record" data-toggle="modal" data-url="' . route('orders.destroy', $order) . '" data-id="' . $order->id . '" data-target="#custom-width-modal">
                    <i class="fa fa-trash"></i>
                    </a>';
                }


                return $btn;
            });
        if (isset(request('search')['value']) && !empty(request('search')['value'])) {
            $datatable->filter(function ($instance) {
                if (
                    in_array(request('search')['value'], [
                        'لم',
                        'لم تسلم',
                        'آجل',
                        'اجل'
                    ])
                ) {
                    return $instance->where('payment_type', 'delayed');
                } else {
                    $term = request('search')['value'];
                    return $instance->whereHas('client', function ($q) use ($term) {
                        $q->where('name', 'like', "%$term%");
                    });
                }
            });
        }
        $roteName = request()->route()->getName();

        if ($roteName == 'orders.report' || $roteName == 'purchase.report') {
            $datatable = $datatable->with('totalOrder', $list->sum('total'));
            $clone = clone $list;
            $datatable = $datatable->with('totalpaid', $clone->sum('paid'));
            $clone = clone $list;
            $datatable = $datatable->with('totaldue', $clone->sum('due'));
            $clone = clone $list;
            $sumDiscount = $clone->get()->sum(function ($item) {
                return $item->dicount_value;
            });
            $datatable = $datatable->with('dicount_value', $sumDiscount);
            $one = clone $list;
            $datatable = $datatable->with('sumPriceOne', $one->priceTypeOne()->sum('total'));
            $multi = clone $list;
            $datatable = $datatable->with('sumPriceOneGomla', $multi->priceTypeGomla()->sum('total'));
            $gomla = clone $list;
            $datatable = $datatable->with('sumPriceOneGomlaGomla', $gomla->priceTypeGomlaGomla()->sum('total'));



            $cashOrders = clone $list;
            $datatable = $datatable->with('cashOrders', $cashOrders->cashOrders()->sum('total'));

            $cashOrders = clone $list;
            $datatable = $datatable->with('postPaidOrders', $cashOrders->postPaidOrders()->sum('total'));

            $cashOrders = clone $list;
            $datatable = $datatable->with('visaOrders', $cashOrders->visaOrders()->sum('total'));

            $cashOrders = clone $list;
            $datatable = $datatable->with('linkTransferOrders', $cashOrders->linkTransferOrders()->sum('total'));
        }
        $datatable->rawColumns(['actions', 'status', 'payment_type', 'is_withdrawable', 'clientname']);
        return $datatable->make(true);
        ;
    }

    public function createSales()
    {
        return $this->create('sales');
    }

    public function createPurchase()
    {
        return $this->create('purchase');
    }

    public function create($type)
    {
        $order = new Order;
        if (request()->notpopup) {
            return view('orders.sale_point', compact('order', 'type'));
        }
        return view('orders.create', compact('order', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNewProduct(&$inputs, $k)
    {

        //dd($inputs['product'],$k);
        $newItem['name'] = $inputs['product'][$k]['product_name'];
        $newItem['observe'] = 0;
        $newItem['main_category_id'] = Category::first()->id;
        $newItem['is_price_percent'] = 0;
        $product = Product::create($newItem);
        $inputs['product'][$k]['cost'] = $inputs['product'][$k]['price'];
        $inputs['product'][$k]['product_id'] = $product->id;
        $sale_price = $inputs['product'][$k]['cost'] + ($inputs['product'][$k]['cost'] * 0.02);
        $unit[$inputs['product'][$k]['unit_id']] = [
            "unit_id" => $inputs['product'][$k]['unit_id'],
            "pieces_num" => "1",
            "cost_price" => $inputs['product'][$k]['cost'],
            "sale_price" => $sale_price,
            "gomla_price" => $sale_price,
        ];
        $product->productUnit()->attach($unit);

        $store[$inputs['product'][$k]['store_id']] = [
            "store_id" => $inputs['product'][$k]['store_id'],
            "sale_count" => 0,
            "qty" => 0,
            "unit_id" => $inputs['product'][$k]['unit_id'],
        ];
        $product->productStore()->attach($store);

    }

    public function store(Request $request)
    {

        $inputs = $request->except('_token');
        try {
            DB::beginTransaction();

            if (Setting::findByKey('enable_empty_invoice') == 0 && !isset($inputs['product'])) {
                throw new \Exception('لا يمكنك إضافة الفاتورة بدون منتجات');
            }
            if (isset($inputs['productNew'])) {
                foreach ($inputs['productNew'] as $k => $product) {
                    if ($product['isnew'] == 'true') {
                        $this->addNewProduct($inputs, $k);
                    }
                }
            }

            $inputs['order']['shipment_amount'] = isset($inputs['order']['shipment_amount']) ? $inputs['order']['shipment_amount'] : 0;
            $inputs['order']['creator_id'] = auth()->user()->id;
            $inputs['order']['invoice_date'] = $inputs['order']['invoice_date'] ?? date('Y-m-d');
            $inputs['order']['discount_type'] = isset($inputs['order']['discount_type']) ? 2 : 1;
            //return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء اضافة الفاتورة ');
            $bank = Bank::where('id', auth()->user()->treasury_id)->first();
            $inputs['order']['bank_id'] = auth()->user()->treasury_id;
            /*if(!in_array($inputs['order']['payment_type'],['cash','delayed'])) {
                $bankId = $inputs['order']['payment_type'];
                $bank = Bank::find($bankId);
                $inputs['order']['payment_type'] = $bank->name;
            }*/

            if (!isset($inputs['order']['invoice_number'])) {

                $lastItem = Order::where('invoice_type', 'sales')
                    ->orderby('id', 'DESC')
                    ->first();
                $invoice_number = $lastItem ? $lastItem->invoice_number + 1 : 1;
                $inputs['order']['invoice_number'] = $invoice_number;
                $inputs['order']['invoice_type'] = 'sales';
                $inputs['order']['payment_type'] = 'cash';
            } else {
                if ($inputs['order']['invoice_type'] == 'sales') {
                    $checkNumber = Order::where('invoice_type', 'sales')->where('invoice_number', $inputs['order']['invoice_number'])->first();
                    if ($checkNumber) {
                        return back()->withInput($inputs)->with('alert-danger', 'رقم الفاتورة ' . $inputs['order']['invoice_number'] . ' مكرر حاول اضافة الفاتورة مره اخرى  ');
                    }
                }
            }

            $inputs['order']['paid_egp'] = currency($inputs['order']['paid'], currency()->getUserCurrency(), currency()->config('default'), $format = false);
            $inputs['order']['is_withdrawable'] = $request->has('is_withdrawable');
            $client = Person::find($inputs['order']['client_id']);
            $pointval = Setting::findByKey('point_value');
            $inputs['order']['use_point'] = isset($inputs['order']['use_point']) ? 1 : 0;
            if ($inputs['order']['use_point'] && $client->total_points) {
                $totalValue = $pointval * $client->total_points;
                $balance = $client->total_points;
                $discount = $totalValue;
                if ($totalValue > $inputs['order']['total']) {
                    $balance = $inputs['order']['total'];
                    $discount = $inputs['order']['total'];
                }
                $inputs['order']['discount_type'] = 1;
                $inputs['order']['discount'] = $discount;
            }

            $order = Order::create($inputs['order']);

            if ($order->invoice_type == 'sales') {
                $logNote = "فاتورة مبيعات رقم " . $order->invoice_number . " للعميل " . $order->client->name . " بقيمة " . $order->total;
            } else {
                $logNote = "فاتورة مشتريات رقم " . $order->invoice_number . " من المورد " . $order->client->name . " بقيمة " . $order->total;
            }
            //activity()->performedOn($order)->log($logNote);
            if ($inputs['order']['use_point'] && $client->total_points) {
                UserPoint::create([
                    'user_id' => $order->client_id,
                    'balance' => -$balance,
                    'order_id' => $order->id
                ]);
            }
            if ($pointval) {
                UserPoint::create([
                    'user_id' => $order->client_id,
                    'balance' => $order->total - $order->discount_value,
                    'order_id' => $order->id
                ]);
            }
            if (isset($inputs['duepayment'])) {
                foreach ($inputs['duepayment']['date'] as $i => $date) {
                    CalanderPayment::create([
                        'order_id' => $order->id,
                        'date' => $date,
                        'value' => $inputs['duepayment']['value'][$i]
                    ]);
                }
            }
            if (isset($inputs['product'])) {
                $rawproductids = [];
                $rawCostPrice = [];
                foreach ($inputs['product'] as $key => $value) {
                    // if(!isset($inputs['product'][$key]['store_id'])){
                    //     $poductRow = Product::with(['productStore','productUnit'])
                    //                 ->where('id',$value['product_id'])
                    //                 ->first();
                    //     $inputs['product'][$key]['store_id'] = $poductRow->productStore->first()->id;
                    //     $inputs['product'][$key]['unit_id'] = $poductRow->productUnit->first()->id;
                    // }
                    $inputs['product'][$key]['total'] = $inputs['product'][$key]['qty'] * $value['price'];
                    $inputs['product'][$key]['cost_egp'] = currency($value['cost'], currency()->getUserCurrency(), currency()->config('default'), $format = false);
                    $inputs['product'][$key]['price_egp'] = currency($value['price'], currency()->getUserCurrency(), currency()->config('default'), $format = false);
                    $rawproductids[] = $value['product_id'];
                    $rawCostPrice[$value['product_id']] = $value['price'];
                }
                if ($order->invoice_type != 'sales') {
                    $raws = DB::table('product_raw_materials')
                        ->whereIn('raw_material_id', $rawproductids)
                        ->pluck('product_id')
                        ->toArray();
                    $rpoduct = Product::with(['rawMatrial', 'productUnit'])
                        ->whereIn('id', $raws)
                        //->where('id',26)
                        ->get();

                    foreach ($rpoduct as $p) {
                        $finalcost = 0;
                        foreach ($p->rawMatrial as $r) {
                            $cost = $rawCostPrice[$r->id] ?? $r->last_cost;
                            $finalcost += ($r->pivot->qty * $cost);
                        }
                        foreach ($p->productUnit as $unit) {
                            $unit->pivot->cost_price = $finalcost * $unit->pivot->pieces_num;
                            $unit->pivot->save();
                        }
                    }
                }
                foreach ($inputs['product'] as $pitem) {
                    //dd($pitem);
                    $pitem['order_id'] = $order->id;
                    OrderDetail::create($pitem);
                }
                //dd("done");
                //$order->details()->attach($inputs['product']);

            } else {
                if (Setting::findByKey('enable_empty_invoice') == 0) {
                    throw new \Exception('لا يمكنك إضافة الفاتورة بدون منتجات');
                }
            }
            event(new OrderCreated($order));
            $clientTrans = $order->client->transactions()
                ->where('record_id', $order->id)
                ->where('transaction_type', $order->invoice_type)
                ->first();
            if ($clientTrans) {
                if ($order->due) {
                    $clientTrans->update([
                        'value' => $order->due,
                        'note' => ' فاتورة رقم ' . $order->invoice_number,
                        'transaction_type' => $order->invoice_type,
                        'record_id' => $order->id
                    ]);
                } else {
                    $clientTrans->delete();
                }
            } elseif ($order->due) {
                $order->client
                    ->transactions()
                    ->create([
                        'value' => $order->due,
                        'note' => ' فاتورة رقم ' . $order->invoice_number,
                        'transaction_type' => $order->invoice_type,
                        'record_id' => $order->id
                    ]);
            }
            //if($order->payment_type=='cash'){
            $trans["bank_id"] = $bank->id;
            if ($order->invoice_type == 'sales') {
                $trans["note"] = " فاتورة مبيعات رقم  " . $order->invoice_number;
            } else {
                $trans["note"] = " فاتورة مشتربات رقم  " . $order->invoice_number;
            }
            $trans["record_id"] = $order->id;
            $trans["op_date"] = date('Y-m-d');
            $trans["total"] = $bank->balance;
            $grand = $order->paid;


            if ($order->invoice_type == 'sales' && $order->paid > 0) {
                $commision = $order->paid * ($bank->percent / 100);
                $grand = $order->paid - $commision;
                $grand = currency($grand, currency()->getUserCurrency(), $bank->currency, $format = false);
                //$commision = currency($commision,$bank->currency,"EGP", $format = false);
                /*$expense['note'] = ' خصم عمولة الفاتورة رقم  '.$order->invoice_number;
                $expense['value'] = $commision;
                Expense::create($expense);*/
                $order->is_visa = $bank->type == 1 ? true : false;
                $order->commision = $commision;
                $order->commision_egp = currency($commision, currency()->getUserCurrency(), currency()->config('default'), $format = false);
                $order->save();
                $trans["due"] = $bank->balance + $grand;
                $bank->balance += $grand;
                $trans["type"] = "2";
            } else {
                $grand = currency($grand, currency()->getUserCurrency(), $bank->currency, $format = false);
                $trans["due"] = $bank->balance - $grand;
                $bank->balance -= $grand;
                $trans["type"] = "1";
            }
            if ($grand > 0) {
                $trans["value"] = $grand;
                $bank->save();
                $order->transaction()->create($trans);
            }
            //BankTransaction::create($trans);
            //}

            DB::commit();
            if ($order->invoice_type == 'sales') {
                $this->setOrderProfit($order);
                $route = route('orders.index');
            } else {
                $route = route('purchases.index');
            }
            //return redirect(route('orders.getPrint',$order->id));
            if (isset($inputs['savePrint']) && $inputs['savePrint'] == 'print') {
                $route = route('orders.getPrint', $order->id);
                if (request()->has('ispos')) {
                    $route .= '?ispos=1';
                }
                return redirect($route);
            }
            if (isset($inputs['saveandPrintBarcode']) && $inputs['saveandPrintBarcode'] == 1) {
                $route = route('orders.getPrintBarcode', $order->id);
                return redirect($route);
            }

            $request->session()->flash('alert-success', 'تم إضافة الفاتورة بنجاح');
            return redirect($route);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء اضافة الفاتورة ' . $e->getMessage());
            //dd($e->getMessage());
            //$request->session()->flash('alert-danger', ' حدث خطأ اثناء اضافة الفاتورة '.$e->getMessage());
            //dd($e->getMessage());
        }
        return back();
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view("orders.show", compact('order'));
    }

    public function getPrint($id)
    {
        $order = Order::find($id);

        return view("orders.print_invoice", compact('order'));
    }
    public function getPrintBarcode($id)
    {
        $order = Order::find($id);
        $generator = new BarcodeGeneratorPNG();
        $allproduct = '';
        $barcodetype = BarcodeGeneratorPNG::TYPE_CODE_128;
        $margin_left = 0.5;
        $margin_top = 0.5;
        $width = 4;
        $height = 2.5;
        foreach ($order->details as $product) {
            $data = compact('generator', 'product', 'barcodetype');
            for ($i = 0; $i < $product->pivot->qty; $i++) {
                $allproduct .= view('orders.barcode5x2', $data);
            }
        }
        return view('orders.print_barcode', [
            'allproduct' => $allproduct,
            'margin_top' => $margin_top,
            'margin_left' => $margin_left,
            'width' => $width,
            'height' => $height
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $type = $order->invoice_type;
        //dd($order->details);
        return view('orders.edit', compact('order', 'type'));
    }


    public function destroy(Order $order)
    {
        $this->rollback($order);
        $order->transaction()->delete();
        $order->client->transactions()
            ->where('record_id', $order->id)
            ->where('transaction_type', $order->invoice_type)
            ->delete();
        if ($order->delete()) {
            return "done";
        }
        return "failed";
    }
    public function deleteworkorder($id)
    {
        try {
            DB::beginTransaction();
            $order = WorkOrder::find($id);
            $details = $order->details;
            foreach ($details as $raw) {
                $productStore = ProductStore::where('product_id', $raw->pivot->raw_unit_id)->first();
                if ($productStore) {
                    $productStore->sale_count -= $raw->pivot->totalneedqty;
                    $productStore->save();
                }
            }
            $productStore = ProductStore::where('product_id', $order->product_id)
                ->where('store_id', $order->store_id)
                ->first();
            $productStore->qty -= $order->itemqty;
            $productStore->save();
            $order->details()->detach();
            if ($order->delete()) {
                DB::commit();
                return "done";
            }
            return "failed";
        } catch (\Exception $e) {
            //\Log::error($e->getMessage());
            DB::rollback();
            dd($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $inputs = $request->except('_token');
        try {
            DB::beginTransaction();
            $oldDue = $order->due;
            $oldClient = $order->client_id;
            $newClient = $inputs['order']['client_id'];
            if ($newClient != $oldClient) {
                $order->client->transactions()
                    ->where('record_id', $order->id)
                    ->where('transaction_type', $order->invoice_type)
                    ->delete();
            }
            //dd($order->transaction);
            $productStores = $this->rollback($order);
            $inputs['order']['discount_type'] = isset($inputs['order']['discount_type']) ? 2 : 1;
            $bank = Bank::where('id', auth()->user()->treasury_id)->first();

            /*if(!in_array($inputs['order']['payment_type'],['cash','delayed'])) {
                $bankId = $inputs['order']['payment_type'];
                $bank = Bank::find($bankId);
                $inputs['order']['payment_type'] = $bank->name;
            }*/
            if (isset($inputs['productNew'])) {
                foreach ($inputs['productNew'] as $k => $product) {
                    if ($product['isnew'] == 'true') {
                        $this->addNewProduct($inputs, $k);
                    }
                }
            }
            $inputs['order']['paid_egp'] = currency($inputs['order']['paid'], currency()->getUserCurrency(), currency()->config('default'), $format = false);
            $inputs['order']['is_withdrawable'] = $request->has('is_withdrawable');
            //dd($inputs['product']);
            $order->fill($inputs['order'])->save();
            if ($order->invoice_type == 'sales') {
                $logNote = "تعديل فاتورة مبيعات رقم " . $order->invoice_number . " للعميل " . $order->client->name . " بقيمة " . $order->total;
            } else {
                $logNote = "تعديل فاتورة مشتريات رقم " . $order->invoice_number . " من المورد " . $order->client->name . " بقيمة " . $order->total;
            }
            activity()->performedOn($order)->log($logNote);
            //$order->fill($inputs['order'])->save();
            $order->calander()->where('is_paid', false)->delete();
            if (isset($inputs['duepayment'])) {
                foreach ($inputs['duepayment']['date'] as $i => $date) {

                    CalanderPayment::create([
                        'order_id' => $order->id,
                        'date' => $date,
                        'value' => $inputs['duepayment']['value'][$i]
                    ]);
                }
            }
            if (!isset($inputs['product'])) {
                $order->details()->detach();
            } else {
                $order->details()->detach();
                foreach ($inputs['product'] as $key => $value) {
                    $inputs['product'][$key]['cost_egp'] = currency($value['cost'], currency()->getUserCurrency(), currency()->config('default'), $format = false);
                    $inputs['product'][$key]['price_egp'] = currency($value['price'], currency()->getUserCurrency(), currency()->config('default'), $format = false);
                }
                //$order->details()->attach($inputs['product']);
                foreach ($inputs['product'] as $pitem) {
                    $pitem['order_id'] = $order->id;
                    OrderDetail::create($pitem);
                }
            }
            event(new OrderCreated($order, $productStores));

            $clientTrans = $order->client->transactions()
                ->where('record_id', $order->id)
                ->where('transaction_type', $order->invoice_type)
                ->first();
            if ($clientTrans) {
                if ($order->due) {
                    $clientTrans->update([
                        'value' => $order->due,
                        'note' => ' فاتورة رقم ' . $order->invoice_number,
                        'transaction_type' => $order->invoice_type,
                        'record_id' => $order->id
                    ]);
                } else {
                    $clientTrans->delete();
                }
            } elseif ($order->due) {
                $order->client
                    ->transactions()
                    ->create([
                        'value' => $order->due,
                        'note' => ' فاتورة رقم ' . $order->invoice_number,
                        'transaction_type' => $order->invoice_type,
                        'record_id' => $order->id
                    ]);
            }
            //if(!in_array($order->payment_type,['cash','delayed'])){
            $trans["bank_id"] = $bank->id;

            if ($order->invoice_type == 'sales') {
                $trans["note"] = " فاتورة مبيعات رقم  " . $order->invoice_number;
            } else {
                $trans["note"] = " فاتورة مشتربات رقم  " . $order->invoice_number;
            }
            $trans["record_id"] = $order->id;
            $trans["op_date"] = $order->invoice_date;
            $trans["total"] = $bank->balance;
            $grand = $order->paid;
            if ($order->invoice_type == 'sales') {
                $commision = $order->paid * ($bank->percent / 100);
                $grand = $order->paid - $commision;
                $grand = currency($grand, currency()->getUserCurrency(), $bank->currency, $format = false);
                $order->is_visa = $bank->type == 1 ? true : false;
                $order->commision = $commision;
                $order->commision_egp = currency($commision, currency()->getUserCurrency(), currency()->config('default'), $format = false);
                $order->save();
                $trans["due"] = $bank->balance + $grand;
                $bank->balance += $grand;
                $trans["type"] = "2";
            } else {
                $grand = currency($grand, currency()->getUserCurrency(), $bank->currency, $format = false);
                $trans["due"] = $bank->balance - $grand;
                $bank->balance -= $grand;
                $trans["type"] = "1";
            }
            $trans["value"] = $grand;
            $bank->save();
            //BankTransaction::create($trans);
            if ($order->transaction) {
                $order->transaction()->update($trans);
            } else {
                $order->transaction()->create($trans);
            }
            //}
            DB::commit();

            if ($order->invoice_type == 'sales') {
                $this->setOrderProfit($order);
                $route = route('orders.index');
            } else {
                $route = route('purchases.index');
            }
            if ($inputs['savePrint'] == 'print') {
                $route = route('orders.getPrint', $order->id);
                return redirect($route);
            }
            if ($inputs['saveandPrintBarcode'] == 1) {
                $route = route('orders.getPrintBarcode', $order->id);
                return redirect($route);
            }

            $request->session()->flash('alert-success', 'تم تعديل الفاتورة بنجاح');
            return redirect($route);
        } catch (\Exception $e) {
            //\Log::error($e->getMessage());
            DB::rollback();
            dd($inputs, $e->getMessage());
            return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء تعديل الفاتورة ' . $e->getMessage());
            //$request->session()->flash('alert-danger', ' حدث خطأ اثناء تعديل الفاتورة '.$e->getMessage());
            //dd($inputs,$e->getMessage());
        }
        return back();
    }

    public function rollback($order)
    {
        //dd($order->transaction);
        /*$order->client->transactions()
            ->where('record_id',$order->id)
            ->where('transaction_type',$order->invoice_type)
            ->delete();*/
        /*$expensenote = ' خصم عمولة الفاتورة رقم  '.$order->invoice_number;
        Expense::where('note',$expensenote)->delete();*/

        $banktans = $order->transaction; //BankTransaction::where('record_id',$order->id)->first();
        $order->commision = 0;
        $order->save();
        if ($banktans) {
            if ($banktans->type == 1) {
                $banktans->bank->balance += $banktans->getOriginal('value');
            } else {
                $banktans->bank->balance -= $banktans->getOriginal('value');
            }
            $banktans->bank->save();
            //$banktans->delete();
        }
        $details = $order->details;
        $productStores = array();
        foreach ($details as $item) {
            if ($item->is_service == 1)
                continue;
            $productStore = ProductStore::where('product_id', $item->id)
                ->where('store_id', $item->pivot->store_id)
                ->first();
            $orderQty = $item->pivot->qty;
            if (empty($productStore)) {
                throw new \Exception(" الصنف $item->name غير معرف بالمخزن برجاء تعديل بيانات الصنف ");
            }
            $prodstorUnit = $productStore->unit_id ?? 1;
            $produtUnits = ProductUnit::where('product_id', $item->id)->get();
            $orderUnit = $produtUnits->where('unit_id', $item->pivot->unit_id)->first();
            $storUnit = $produtUnits->where('unit_id', $prodstorUnit)->first();

            if (empty($orderUnit)) {
                throw new \Exception(" وحدة الصنف $item->name الموجودة بالفاتورة لا تندرج تحت وحدات الصنف المعرفة ");
            }
            if ($prodstorUnit != $item->pivot->unit_id) {
                if ($storUnit->pieces_num < $orderUnit->pieces_num) {
                    $a = $orderUnit->pieces_num / $storUnit->pieces_num;
                    $orderQty = $orderQty * $a;
                } else {
                    $a = $orderUnit->pieces_num / $storUnit->pieces_num;
                    if ($a < 1) {
                        $orderQty = $orderQty * $a;
                    } else {
                        $orderQty = $orderQty / $a;
                    }
                }
            }

            if ($item->pivot->bounse) {
                $bounse = $item->pivot->bounse;
                $bounseUnit = $produtUnits->where('unit_id', $item->pivot->bounse_unit_id)->first();
                if ($prodstorUnit != $item->pivot->bounse_unit_id) {
                    if ($storUnit->pieces_num < $bounseUnit->pieces_num) {
                        $a = $bounseUnit->pieces_num / $storUnit->pieces_num;
                        $a = $bounseUnit->pieces_num / $storUnit->pieces_num;
                        $bounse = $bounse * $a;
                    } else {
                        $a = $bounseUnit->pieces_num / $storUnit->pieces_num;
                        if ($a < 1) {
                            $bounse = $bounse * $a;
                        } else {
                            $bounse = $bounse / $a;
                        }
                    }
                }
                $orderQty += $bounse;
            }


            if ($order->status == 'delivered') {

                if ($order->invoice_type == 'sales') {
                    $productStore->sale_count -= $orderQty;
                } else {
                    $productCost = $item->last_cost;
                    if (Setting::findByKey('productCost') == 'avg') {
                        $oldCost = $orderUnit->cost_price;
                        $oldQty = ($productStore->qty - $productStore->sale_count) ?: 1;
                        $newQty = $orderQty;
                        $newCost = $item->pivot->price;
                        $totalNew = ($newQty * $newCost) / $oldQty;
                        $revertCost = $oldCost + $totalNew;
                        $productCost = $orderUnit->cost_price;
                    }
                    $orderUnit->cost_price = $productCost;
                    $orderUnit->save();

                    $productStore->qty -= $orderQty;
                    $item->last_cost = $productCost;
                    $item->avg_cost = round($productCost, 2);
                    $item->save();
                }
                $productStore->save();
                $productStores[$item->id . $item->pivot->store_id] = $productStore;
                //\Log::info($item->id.' '.($productStore->qty-$productStore->sale_count));

            }
        }
        return $productStores;

    }

    public function changeStatus(Order $order)
    {
        try {
            DB::beginTransaction();
            $order->update(['status' => 'delivered']);
            event(new OrderCreated($order));
            DB::commit();
            return back()->with('alert-success', 'تم تغيير حالة الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('alert-danger', 'حطأ! لم تتم العملية بنجاح');
        }
    }

    public function getDetails(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $orders = Order::where('invoice_type', 'sales');
        if ($from) {
            $orders->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
        }
        if ($to) {
            $orders->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
        }
        $orders = $orders->latest()->get();
        return view('orders.details', compact('orders'));
    }

    public function getWorkOrders(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $orders = WorkOrder::query()->with('details');
        if ($from) {
            $orders->whereRaw("DATE(date) >= '{$from}'");
        }
        if ($to) {
            $orders->whereRaw("DATE(date) <= '{$to}'");
        }
        $orders = $orders->latest()->get();
        return view('orders.workorders_list', compact('orders'));
    }

    public function allworkorders(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $orders = WorkOrder::query()->with('details');
        if ($from) {
            $orders->whereRaw("DATE(date) >= '{$from}'");
        }
        if ($to) {
            $orders->whereRaw("DATE(date) <= '{$to}'");
        }
        $orders = $orders->latest()->get();
        return view('orders.allworkorders', compact('orders'));
    }

    public function workorders(Request $req)
    {
        if ($req->isMethod('post')) {
            try {
                DB::beginTransaction();
                $inputs = $req->all();
                $order = WorkOrder::create($inputs);
                $order->details()->attach($inputs['raw']);
                foreach ($inputs['raw'] as $raw) {
                    $productStore = ProductStore::where('product_id', $raw['raw_unit_id'])->first();
                    if ($productStore) {
                        $productStore->sale_count += $raw['totalneedqty'];
                        $productStore->save();
                    }
                }
                $productStore = ProductStore::where('product_id', $inputs['product_id'])
                    ->where('store_id', $inputs['store_id'])
                    ->firstOrCreate(
                        [
                            'product_id' => $inputs['product_id'],
                            'store_id' => $inputs['store_id'],
                            "unit_id" => $inputs['unit_id']
                        ],
                        [
                            'product_id' => $inputs['product_id'],
                            'store_id' => $inputs['store_id'],
                            'qty' => 0,
                            'sale_count' => 0,
                            "unit_id" => $inputs['unit_id']
                        ]
                    );
                $productStore->qty += $inputs['itemqty'];
                $productStore->save();
                DB::commit();
                return back()->with('alert-success', 'تم اصدار امر التصنيع بنجاح');
            } catch (\Exception $e) {
                DB::rollback();
                //throw new \Exception('خطأ استرجاع الكمية الى المخزن ');
                dd($e->getMessage());
            }
        }
        return view('orders.work_order');
    }
    public function getSalesDebt()
    {
        /*$result = Order::selectRaw('sum(due) as totalDept')
            ->where('invoice_type','sales')
            ->where('sale_id',request('sale_id'))
            ->groupBy('sale_id')
            ->first();*/
        $persons = Person::join('orders', function ($qry) {
            $qry->on('persons.id', '=', 'client_id');
            $qry->whereNotNull('sale_id');
        })
            ->where('is_client_supplier', 1)
            ->selectRaw('persons.*,sale_id')
            ->groupBy('client_id')
            ->get();
        $salesP = [];
        foreach ($persons as $p) {
            $salesP[$p->sale_id] = $p->balnce_value;
        }
        if (!isset($salesP[request('sale_id')])) {
            $salesP[request('sale_id')] = 0;
        }
        //return $salesP[request('sale_id')];
        //dd($salesP);
        $result = Order::selectRaw('employees.id,employees.name,sum(due) as totalDept')
            ->join("persons", function ($qry) {
                $qry->on('persons.id', '=', 'client_id');
                $qry->where('is_client_supplier', 0);
            })
            ->join("employees", function ($qry) {
                $qry->on('employees.id', '=', 'sale_id');
            })
            ->addSelect(
                \DB::raw(
                    '(select sum(return_value) from returns
                    where return_type = "sales" and returns.sale_id=orders.sale_id)
                     as totalReturn'
                )
            )
            ->where('invoice_type', 'sales')
            ->where('sale_id', request('sale_id'))
            ->groupBy('sale_id')
            ->having('totalDept', '>', 0)
            ->first();

        return $result->totalDept - $result->totalReturn;
    }

    public function pos()
    {
        $categories = Category::query()->with(['products', 'products.productUnit'])->get();
        return view('orders.pos', compact('categories'));
    }

    public function createTurpoShipment($id)
    {
        $order = Order::find($id);
        if (request()->isMethod('POST')) {
            try {
                $headers = [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ];
                $client = new Client([
                    'headers' => $headers
                ]);
                $summery = '';
                foreach ($order->details as $item) {
                    $summery .= $item->full_name . ' ';
                }
                $reciver = optional($order->client);
                $area = optional($reciver->client);
                $governmentName = optional($area->government)->name;
                // if ($reciver->area_id != request('area_id')) {
                // }

                $reciver->area_id = request('area_id');
                $reciver->save();
                $area = Area::find(request('area_id'));
                $government = Government::find(request('government_id'));
                $governmentName = $government->name ?? '';
                $order->shipment_amount = request('shipment_amount');

                $order->save();
                $data = [
                    "authentication_key" => env('turbo_authentication_key'),
                    "main_client_code" => env('turbo_client_code'),
                    "second_client" => "شركة كيان للإستيراد",
                    "receiver" => $reciver->name,
                    "phone1" => $reciver->mobile,
                    "phone2" => $reciver->mobile2,
                    "api_followup_phone" => "+201227474808",
                    "government" => $governmentName,
                    "area" => $area->name,
                    "address" => $reciver->address,
                    "notes" => "الطرد قابل للكسر",
                    "invoice_number" => $order->id,
                    "order_summary" => $summery,
                    "amount_to_be_collected" => request('totalWithShipment'),
                    "return_amount" => request('shipment_amount'),
                    "is_order" => 0,
                    "return_summary" => $summery,
                    "can_open" => 1
                ];
                $res = $client->get('https://backoffice.turbo-eg.com/external-api/add-order', [RequestOptions::JSON => $data]);

                $responseJSON = json_decode($res->getBody(), true);
                if ($responseJSON['success'] == 1) {
                    $order->is_shipped = 1;
                    $order->save();
                    return back()->with('alert-success', 'تم اضافة الطرد بنجاح');
                } else {
                    $error_msg = $responseJSON['error_msg'];
                    //dd($data, $error_msg, $responseJSON);
                    return back()->with('alert-danger', ' حدث خطأ اثناء اضافة الطرد ' . $error_msg);
                }
            } catch (\Exception $e) {
                return back()->with('alert-danger', ' حدث خطأ اثناء اضافة الطرد ' . $e->getMessage());
            }
        } else {
            return view('orders.create_shipment', compact('order'));
        }
    }
}