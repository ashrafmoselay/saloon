<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankTransaction;
use App\Category;
use App\Expense;
use App\Imports\ClientsImport;
use App\Imports\ProductsImport;
use App\Imports\SuppliersImport;
use App\Order;
use App\OrderDetail;
use App\Partner;
use App\PartnerProfit;
use App\Person;
use App\Product;
use App\ProductStore;
use App\ProductUnit;
use App\ReturnDetail;
use App\ReturnProduct;
use App\Role;
use App\Setting;
use App\Shipment;
use App\ShipmentDetailes;
use App\Store;
use App\Transaction;
use App\TresuryTranaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{

    public function updateShipment()
    {
        $list = ShipmentDetailes::query()->where('status', 'مرتجع')->get();
        foreach ($list as $row) {
            $row->returned_qty = $row->qty;
            $row->save();
        }
        BankTransaction::query()->truncate();
        Transaction::query()->truncate();
        Expense::query()->truncate();
        die("done in " . now());
    }

    public function combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_key => $property_value) {
                    $tmp[] = $result_item + array($property_key => $property_value);
                }
            }
            $result = $tmp;
        }
        return $result;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkUniqId()
    {
        $mac = $this->getUniqueMachineID();
        if (file_exists('macAdd.php')) {
            $data = file_get_contents('macAdd.php');
            //dd($data,$mac);
            if ($mac != $data) {
                die('Not Allowed');
            }
        } else {
            file_put_contents('macAdd.php', $mac);
        }
    }

    function getUniqueMachineID($salt = "")
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $temp = "diskpartscript.txt";
            if (!file_exists($temp) && !is_file($temp))
                file_put_contents($temp, "select disk 0\ndetail disk");
            $output = shell_exec("diskpart /s " . $temp);
            $lines = explode("\n", $output);
            $result = array_filter($lines, function ($line) {
                return stripos($line, "ID:") !== false;
            });
            if (count($result) > 0) {
                $d = array_values($result);
                $result = array_shift($d);
                $result = explode(":", $result);
                $result = trim(end($result));
            } else
                $result = $output;
        } else {
            $result = shell_exec("blkid -o value -s UUID");
            if (stripos($result, "blkid") !== false) {
                $result = $_SERVER['HTTP_HOST'];
            }
        }
        return md5($salt . md5($result));
    }

    function calculatePriceFromGomla()
    {
        $products = ProductUnit::get();
        foreach ($products as $p) {
            $gomla = round($p->sale_price, 2);
            $cost = $gomla - ($gomla * 0.1);
            $sale = $gomla + ($gomla * 0.1);
            $p->gomla_price = $gomla;
            $p->cost_price = round($cost, 2);
            ;
            $p->sale_price = round($sale, 2);
            ;
            $p->save();
        }
    }

    public function updateProductStore()
    {
        $products = Product::with('productStore')->get();
        foreach ($products as $product) {
            if (!count($product->productStore)) {
                ProductStore::create([
                    'product_id' => $product->id,
                    'store_id' => 1,
                    'unit_id' => 1,
                    'qty' => 0,
                    'sale_count' => 0
                ]);
            }
        }
        dd("done");
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
    public function index()
    {

        //$this->calculatePriceFromGomla();
        //activity()->log('Look, I logged something');

        /* $products = OrderDetail::with('product.productUnit')->get();
         foreach ($products as $p){
             $available = $p->product->productUnit()->pluck('units.id')->toArray();
             if(!in_array($p->unit_id,$available)){
                 $unit = $p->product->productUnit()->first();
                 $p->unit_name =$unit->name;
                 $p->unit_id = $unit->id;
                 $p->save();
             }
         }
         die('done');*/
        //$from = '2022-02-01';
        //  $orderDetails = OrderDetail::get();
        //  foreach($orderDetails as $det){
        //     $unit = $det->product->productUnit()->where('unit_id',$det->unit_id)->first();
        //     $det->cost_egp = $unit->pivot->cost_price;
        //     $det->cost = $unit->pivot->cost_price;
        //     $det->save();
        //  }

        // $list = Order::where('invoice_type','sales')->get();
        // if($list){
        //     foreach ($list as $order){
        //         $order->profit =  $order->order_profit;
        //         $order->save();
        //     }
        // }
        // die('here');

        /*$ordersdeleted = DB::table('orders')
            ->whereNotNull('is_deleted')
            ->pluck('id')->all();
        Transaction::whereIn('record_id',$ordersdeleted)
            ->whereIn('transaction_type',['sales','purchase'])
            ->delete();
        dd($ordersdeleted);*/
        //$this->checkUniqId();
        //dd(strtotime('2020-03-15'));
        //DB::table('persons')->truncate();
        //DB::table('transactions')->truncate();
        //Artisan::call('storage:link');

        /*DB::table('persons')->truncate();
        DB::table('transactions')->truncate();
        DB::table('product_store')->update(['qty'=>0,'sale_count'=>0]);
        DB::table('product_unit')->update(['cost_price'=>0,'sale_price'=>0,'gomla_price'=>0,'gomla_gomla_price'=>0]);
        $categ = Category::whereNotIN('id',[1,2,3,4,5,7,9,15])->get();
        foreach ($categ as $c){
            $c->products()->delete();
            $c->delete();
        }
        die('done');*/

        //old store
        /* DB::table('persons')->truncate();
         DB::table('transactions')->truncate();
         DB::table('product_store')->update(['qty'=>0,'sale_count'=>0]);
         $categ = Category::whereNotIN('id',[1,2,3,4,5,8,10,11,12,13,15,26])->get();
         foreach ($categ as $c){
             $c->products()->delete();
             $c->delete();
         }
         die('done');*/
        $expenses = Expense::where('created_at', '>=', date('Y-m-d'))->sum('value');
        $ordersList = Order::where('created_at', '>=', date('Y-m-d'))
            ->select(DB::raw('invoice_type,sum(total-discount_value) as grandTotal'))
            ->groupBy('invoice_type')
            ->get();
        $todayOrders = $ordersList->where('invoice_type', 'sales')->first();
        $todayOrders = $todayOrders->grandTotal ?? 0;
        $totdayPurchases = $ordersList->where('invoice_type', 'purchase')->first();
        $totdayPurchases = $totdayPurchases->grandTotal ?? 0;
        $returnsList = ReturnProduct::where('created_at', '>=', date('Y-m-d'))->get();
        $orderReturn = $returnsList->where('return_type', 'sales');
        $orderReturn = $orderReturn->sum('return_value') ?? 0;
        $purchaseReturn = $returnsList->where('return_type', 'purchase');
        $purchaseReturn = $purchaseReturn->sum('return_value') ?? 0;
        return view('home', compact('todayOrders', 'expenses', 'totdayPurchases', 'purchaseReturn', 'orderReturn'));
    }
    public function summery()
    {
        $bestSeller = ProductStore::query()->join('products', function ($qry) {
            $qry->on('product_id', '=', 'products.id');
            $qry->where('is_raw_material', 0);
        })
            ->where('sale_count', '>', 0)
            ->take(7)
            ->orderBy('sale_count', 'DESC')
            ->groupBy('product_id')
            ->get();

        $gard = ProductUnit::query()->has('product')
            ->select(DB::raw('sum((select sum(qty-sale_count) from product_store
where product_unit.unit_id=product_store.unit_id and
product_store.product_id=product_unit.product_id) * product_unit.cost_price)
 as totalCost'))->first();

        $clientsList = Person::query()
            ->where('type', 'client')
            ->whereNull('deleted_at')
            ->get();
        $totaldeptofClient = 0;
        foreach ($clientsList as $sup) {
            $totaldeptofClient += $sup->getFinalDue();
        }
        $clientdue = floor($totaldeptofClient);



        $suppliersList = Person::query()
            ->where('type', 'supplier')
            ->whereNull('deleted_at')
            ->get();
        $totaldeptofSupplier = 0;
        foreach ($suppliersList as $sup) {
            $totaldeptofSupplier += $sup->getFinalDue();
        }
        $supplierdue = floor($totaldeptofSupplier);

        $discounts = Order::where('discount', '>', 0)->get();
        $discountSum = 0;
        foreach ($discounts->where('invoice_type', 'sales') as $ord) {
            if ($ord->discount_type == 2) {
                $discountSum += ($ord->total * ($ord->discount / 100));
            } else {
                $discountSum += $ord->discount;
            }
        }
        $discountSum2 = 0;
        foreach ($discounts->where('invoice_type', 'purchase') as $ord) {
            if ($ord->discount_type == 2) {
                $discountSum2 += ($ord->total * ($ord->discount / 100));
            } else {
                $discountSum2 += $ord->discount;
            }
        }
        $totalOrders = Order::where('invoice_type', 'sales')
            ->where('invoice_type', 'sales')
            ->selectRaw('currency,sum(total) as total')
            ->groupBy('currency')
            ->get()->toArray();
        $totalPurchases = Order::where('invoice_type', 'purchase')->sum('total');
        $totalPurchases -= $discountSum2;
        //$deposite = TresuryTranaction::where('type','deposite')->sum('value');
        //$withdraw = TresuryTranaction::where('type','withdraw')->sum('value');
        $treasury = $this->getCashMoney();
        //dd($treasury);
        return view('summery', compact('discountSum', 'treasury', 'totalOrders', 'totalPurchases', 'supplierdue', 'clientdue', 'gard', 'bestSeller'));

    }

    public function closeYear()
    {
        try {
            $copy = $this->cloneDB();
            // DB::table('stores')->truncate();
            // DB::table('products')->truncate();
            // DB::table('persons')->truncate();
            // dd("ok");
            DB::beginTransaction();

            $balance = array();
            foreach (Person::get() as $person) {
                $b = $person->balnce_value;
                if ($b)
                    $balance[$person->id] = $b;
            }
            DB::statement("UPDATE product_store SET qty = qty - sale_count,sale_count = 0;");


            DB::table('orders')->truncate();
            DB::table('order_detailes')->truncate();
            //DB::table('products')->delete();
            DB::table('returns')->truncate();
            DB::table('return_detailes')->truncate();
            DB::table('transactions')->truncate();
            DB::table('expenses')->truncate();
            DB::table('tresury_tranactions')->truncate();
            DB::table('bank_transactions')->truncate();
            DB::table('movements')->truncate();
            DB::table('movement_invoice')->truncate();
            DB::table('activity_log')->truncate();
            DB::table('damages')->truncate();
            DB::table('partner_profit')->truncate();
            DB::table('transactions')->truncate();
            $perIds = array_keys($balance);
            $persons = Person::whereIn('id', $perIds)->get();
            foreach ($persons as $person) {
                $person->transactions()
                    ->create([
                        'value' => $balance[$person->id],
                        'note' => 'رصيد أول المدة'
                    ]);
            }
            DB::commit();
            return asset($copy);
            /*$orginal = "database.sqlite";
            $copy = 'database.sqlite';
            $path = storage_path($orginal);
            \File::copy($path,base_path('public/'.$copy));
            $path = public_path($copy);*/
            //return response()->download($path, date('Y-m-d').'_'.$copy);
            //response()->download($path, date('Y-m-d').'_'.$copy);
            //request()->session()->flash('alert-success', trans('front.Successfully added'));
        } catch (\Exception $e) {
            DB::rollback();
            request()->session()->flash('alert-danger', trans('app.Some Error was ocuured during opertion!') . $e->getMessage());
        }
        dd("Done in" . now());
        return route('home');

    }
    public function cloneDB()
    {
        $orginal = "database.sqlite";
        $path = storage_path($orginal);
        $copy = date('Y-m-d') . '_cloneDB_database.sqlite';
        \File::copy($path, base_path('public/' . $copy));
        return $copy;
    }
    public function backup()
    {
        $orginal = "database.sqlite";
        $copy = 'database.sqlite';
        if (session('mydbcon') == 'sqlite2') {
            $orginal = "database2.sqlite";
            $copy = 'db2.sqlite';
        }
        //$copy = date('Y-m-d').$copy;
        $path = storage_path($orginal);
        \File::copy($path, base_path('public/' . $copy));
        $path = public_path($copy);
        return response()->download($path, date('Y-m-d') . '_' . $copy);
    }


    public function cleanDB()
    {
        $copy = $this->cloneDB();
        $users = \App\User::get();
        $settings = Setting::get();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        \DB::table('users')->truncate();
        \DB::table('settings')->truncate();
        //$roles = Role::get()->pluck('id')->toArray();
        foreach ($users as $user) {
            if (optional($user->roles()->first())->id) {
                \App\User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                    'remember_token' => str_random(10)
                ]);
            }
        }
        foreach ($settings as $set) {
            Setting::create([
                'name' => $set->name,
                'key' => $set->key,
                'value' => $set->value,
            ]);
        }
        // request()->session()->flash('alert-success', 'تم مسح كل البيانات بنجاح ');
        return asset($copy);
        //return response()->download(, date('Y-m-d').'_'.$copy);
        //return route('home');// redirect(route('home',request('clientId')));
    }

    public function migrate()
    {
        Artisan::call('migrate');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('storage:link');
        request()->session()->flash('alert-success', 'تم دمج الدتابيز بنجاح');
        return redirect(route('home'));
    }


    public function updateProductPricePersent()
    {
        Product::query()->update(['is_price_percent' => 1, 'product_percent_only' => 0]);
        request()->session()->flash('alert-success', 'تم تحديد نسبة الزيادة على كل المنتجات على حسب الفئة');
        return redirect(route('home'));
    }

    public function clearCache()
    {
        // $ordersdeleted = DB::table('orders')
        //     ->whereNotNull('deleted_at')
        //     ->pluck('id')
        //     ->all();
        //     //dd($ordersdeleted);
        // Transaction::whereIn('record_id',$ordersdeleted)
        //     ->whereIn('transaction_type',['sales','purchase'])
        //     ->delete();
        $storageLink = public_path() . '/storage';
        /*if (File::exists($storageLink)) {
            unlink($storageLink);
        }*/
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('storage:link');
        request()->session()->flash('alert-success', 'تم مسح الكاش بنجاح ');
        return redirect(route('home'));
    }

    public function restore(Request $request)
    {
        if ($request->isMethod('post')) {
            $file = $request->file('file');
            if (session('mydbcon') == 'sqlite2') {
                $file->storeAs('', 'database2.sqlite');
            } else {
                $file->storeAs('', 'database.sqlite', ['disk' => 'local']);
            }
            $request->session()->flash('alert-success', 'تم إسترجاع نسخة البيانات بنجاح');
            \DB::reconnect();
            Artisan::call('migrate');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            return redirect(route('home'));
        }
        return view('restore');
    }

    public function developer()
    {
        return view('developer');
    }

    public function dailyreport(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $transactions = BankTransaction::query();
        $orders = Order::query();
        $orders->where('invoice_type', 'sales');
        $purchase = Order::query();
        $purchase->where('invoice_type', '<>', 'sales');
        $salesReturns = ReturnProduct::query();
        $salesReturns->where('return_type', 'sales');
        $purchaseReturns = ReturnProduct::query();
        $purchaseReturns->where('return_type', '<>', 'sales');
        if ($from) {
            $orders->whereRaw("DATE(invoice_date) >= '{$from}'");
            $purchase->whereRaw("DATE(invoice_date) >= '{$from}'");
            $salesReturns->whereRaw("DATE(return_date) >= '{$from}'");
            $purchaseReturns->whereRaw("DATE(return_date) >= '{$from}'");
            $transactions->whereRaw("DATE(op_date) >= '{$from}'");
        }
        if ($to) {
            $orders->whereRaw("DATE(invoice_date) <= '{$to}'");
            $purchase->whereRaw("DATE(invoice_date) <= '{$to}'");
            $salesReturns->whereRaw("DATE(return_date) <= '{$to}'");
            $purchaseReturns->whereRaw("DATE(return_date) <= '{$to}'");
            $transactions->whereRaw("DATE(op_date) <= '{$to}'");
        }
        $salesOrders = clone $orders;
        $purchaseOrders = clone $purchase;
        $salesOrders = $salesOrders->get();
        $purchaseOrders = $purchaseOrders->get();
        $sumDiscount = $salesOrders->sum(function ($item) {
            return $item->dicount_value;
        });
        $sumOrdersDiscount = $sumDiscount ?: 0;
        $sumDiscount = $purchaseOrders->sum(function ($item) {
            return $item->dicount_value;
        });
        $sumPurchaseDiscount = $sumDiscount ?: 0;

        $orders->selectRaw('sum(total-discount_value) as grandTotal,sum(due) as totalDue,sum(paid) as totalPaid,count(id) as OrdersCount');
        //$orders->where('due','>=',0);
        $purchase->selectRaw('sum(total-discount_value) as grandTotal,sum(due) as totalDue,sum(paid) as totalPaid,count(id) as OrdersCount');
        $purchase = $purchase->first();
        $orders = $orders->first();
        $transactions->selectRaw('sum(value) as totalSum,transactionable_type,type');
        $transactions->groupBy(['transactionable_type', 'type']);
        $transactions = $transactions->get();
        //dd($transactions);
        $clientPayments = $transactions->where('transactionable_type', Person::class)
            ->where('type', 2)->first();
        $supplierPayments = $transactions->where('transactionable_type', Person::class)
            ->where('type', 1)->first();
        $expenses = $transactions->where('transactionable_type', Expense::class)
            ->where('type', 1)->first();
        $supplierOrders = $transactions->where('transactionable_type', Order::class)
            ->where('type', 1)->first();
        $clientOrders = $transactions->where('transactionable_type', Order::class)
            ->where('type', 2)->first();
        $withdraw = $transactions->where('transactionable_type', Bank::class)
            ->where('type', 1)->first();
        $desposite = $transactions->where('transactionable_type', Bank::class)
            ->where('type', 2)->first();
        $clientPayments = $clientPayments->totalSum ?? 0;
        $supplierPayments = $supplierPayments->totalSum ?? 0;
        $expenses = $expenses->totalSum ?? 0;
        $supplierOrders = $supplierOrders->totalSum ?? 0;
        $clientOrders = $clientOrders->totalSum ?? 0;
        $desposite = $desposite->totalSum ?? 0;
        $withdraw = $withdraw->totalSum ?? 0;

        return view('day_report', [
            'transactions' => $transactions,
            'orders' => $orders,
            'clientPayments' => $clientPayments,
            'supplierPayments' => $supplierPayments,
            'expenses' => $expenses,
            'supplierOrders' => $supplierOrders,
            'clientOrders' => $clientOrders,
            'withdraw' => $withdraw,
            'desposite' => $desposite,
            'balance' => $this->getCashMoney(),
            'purchase' => $purchase,
            'salesReturns' => $salesReturns,
            'purchaseReturns' => $purchaseReturns
        ]);
    }

    public function dailyreport2(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $orders = Order::where('invoice_type', 'sales')
            ->where('is_visa', 0)
            ->selectRaw('currency,sum(paid) as paid,sum(due) as due')
            ->groupBy('currency');
        $visaOrders = Order::where('invoice_type', 'sales')
            ->where('is_visa', 1)
            ->selectRaw('currency,sum(paid-commision) as paid,sum(due) as due')
            ->groupBy('currency');
        $purchases = Order::where('invoice_type', 'purchase');
        $expenses = Expense::query();

        $bankTransaction = BankTransaction::join('banks', function ($qry) {
            $qry->on('bank_id', '=', 'banks.id');
        })->where(function ($query) {
            $query->where('banks.type', 1);
            $query->orwhere(function ($q) {
                $q->where('banks.type', 2);
                $q->where('bank_transactions.type', 1);
            });
            $query->orwhere(function ($q) {
                $q->whereNull('record_id');
                $q->where('banks.type', 2);
            });
        })->selectRaw('sum(value) as totalValue,banks.currency,bank_transactions.type,banks.name')
            ->groupBy(['currency', 'bank_transactions.type']);

        $prevbankTransaction = BankTransaction::join('banks', function ($qry) {
            $qry->on('bank_id', '=', 'banks.id');
        })->where(function ($query) {
            $query->where('banks.type', 1);
            $query->orwhere(function ($q) {
                $q->where('banks.type', 2);
                $q->where('bank_transactions.type', 1);
            });
            $query->orwhere(function ($q) {
                $q->whereNull('record_id');
                $q->where('banks.type', 2);
            });
        })->selectRaw('sum(value) as totalValue,banks.currency,bank_transactions.type,banks.name')
            ->groupBy(['currency', 'bank_transactions.type']);

        /*$prevbankTransaction = BankTransaction::join('banks',function($qry){
            $qry->on('bank_id', '=', 'banks.id');
            $qry->where('banks.type',1);
        })->selectRaw('sum(value) as totalValue,banks.currency,bank_transactions.type,banks.name')
            ->groupBy(['currency','bank_transactions.type']);*/
        //dd($bankTransaction->get()->toArray());
        /* $returns = DB::table('return_detailes')
             ->select(DB::raw('sum(qty*price - qty*cost) as totalRetutn'));*/
        $deposite = TresuryTranaction::where('type', 'deposite');
        $withdraw = TresuryTranaction::where('type', 'withdraw');
        $clienttotalPayment = DB::table('transactions')->join('persons', function ($qry) {
            $qry->on('model_id', '=', 'persons.id');
            $qry->where('note', '!=', ' خصم قيمة مرتجعات من الحساب ');
            $qry->where('note', '!=', 'خصم اضافى عند التحصيل');
            $qry->where('note', '!=', 'رصيد أول المدة');
            $qry->where('model_type', 'App\Person');
            $qry->where('type', 'client');
            $qry->where('value', '<', 0);
            $qry->whereNull('transactions.deleted_at');
            $qry->whereNull('persons.deleted_at');
        });
        $suppliertotalPayment = DB::table('transactions')->join('persons', function ($qry) {
            $qry->on('model_id', '=', 'persons.id');
            $qry->where('model_type', 'App\Person');
            $qry->where('note', '!=', ' خصم قيمة مرتجعات من الحساب ');
            $qry->where('note', '!=', 'خصم اضافى عند التحصيل');
            $qry->where('note', '!=', 'رصيد أول المدة');
            $qry->where('type', 'supplier');
            $qry->where('value', '<', 0);
            $qry->whereNull('transactions.deleted_at');
            $qry->whereNull('persons.deleted_at');
        });

        $prevorders = Order::where('invoice_type', 'sales')
            ->selectRaw('currency,sum(paid-commision) as paid,sum(due) as due')
            ->where('commision', 0)
            ->groupBy('currency');
        $prevpurchases = Order::where('invoice_type', 'purchase');
        $prevexpenses = Expense::query();
        $prevdeposite = TresuryTranaction::where('type', 'deposite');
        $prevwithdraw = TresuryTranaction::where('type', 'withdraw');
        $prevclienttotalPayment = DB::table('transactions')->join('persons', function ($qry) {
            $qry->on('model_id', '=', 'persons.id');
            $qry->where('note', '!=', ' خصم قيمة مرتجعات من الحساب ');
            $qry->where('note', '!=', 'خصم اضافى عند التحصيل');
            $qry->where('note', '!=', 'رصيد أول المدة');
            $qry->where('model_type', 'App\Person');
            $qry->where('type', 'client');
            $qry->where('value', '<', 0);
            $qry->whereNull('transactions.deleted_at');
            $qry->whereNull('persons.deleted_at');
        });
        $prevsuppliertotalPayment = DB::table('transactions')->join('persons', function ($qry) {
            $qry->on('model_id', '=', 'persons.id');
            $qry->where('model_type', 'App\Person');
            $qry->where('note', '!=', ' خصم قيمة مرتجعات من الحساب ');
            $qry->where('note', '!=', 'خصم اضافى عند التحصيل');
            $qry->where('note', '!=', 'رصيد أول المدة');
            $qry->where('type', 'supplier');
            $qry->where('value', '<', 0);
            $qry->whereNull('transactions.deleted_at');
            $qry->whereNull('persons.deleted_at');
        });
        $prevBalance[currency()->config('default')] = 0;
        if ($from) {

            $bankTransaction->whereRaw("DATE(op_date) >= '{$from}'");
            $orders->whereRaw("DATE(invoice_date) >= '{$from}'");
            $visaOrders->whereRaw("DATE(invoice_date) >= '{$from}'");

            $purchases->whereRaw("DATE(invoice_date) >= '{$from}'");
            $expenses->whereRaw("DATE(created_at) >= '{$from}'");
            $deposite->whereRaw("DATE(created_at) >= '{$from}'");
            $withdraw->whereRaw("DATE(created_at) >= '{$from}'");
            $clienttotalPayment->whereRaw("DATE(transactions.created_at) >= '{$from}'");
            $suppliertotalPayment->whereRaw("DATE(transactions.created_at) >= '{$from}'");

            $prevorders->whereRaw("DATE(invoice_date) < '{$from}'");
            $prevpurchases->whereRaw("DATE(invoice_date) < '{$from}'");
            $prevexpenses->whereRaw("DATE(created_at) < '{$from}'");
            $prevdeposite->whereRaw("DATE(created_at) < '{$from}'");
            $prevwithdraw->whereRaw("DATE(created_at) < '{$from}'");
            $prevclienttotalPayment->whereRaw("DATE(transactions.created_at) < '{$from}'");
            $prevsuppliertotalPayment->whereRaw("DATE(transactions.created_at) < '{$from}'");

            $prevbankTransaction->whereRaw("DATE(op_date) < '{$from}'");
            $prevorders = $prevorders->get()->toArray();

            $prevordersCurrency[currency()->config('default')] = 0;
            foreach ($prevorders as $ord) {
                $prevordersCurrency[$ord['currency']] = $ord['paid'];
            }
            //dd($prevordersCurrency);
            //$prevorders = $prevorders->sum('paid');
            $prevpurchases = $prevpurchases->sum('paid');
            $prevexpenses = $prevexpenses->sum('value');


            /*$prevdeposite = $prevdeposite->sum('value');
            $prevwithdraw = $prevwithdraw->sum('value');*/

            $prevdepositeTrans[currency()->config('default')] = $prevdeposite->sum('value');
            $prevwithdrawTrans[currency()->config('default')] = $prevwithdraw->sum('value');

            $currencyTrans = $prevbankTransaction->get()->toArray();
            //dd($currencyTrans);
            foreach ($currencyTrans as $trans) {
                if ($trans['type'] == 1) {
                    if (isset($prevwithdrawTrans[$trans['currency']])) {
                        $prevwithdrawTrans[$trans['currency']] += $trans['totalValue'];
                    } else {
                        $prevwithdrawTrans[$trans['currency']] = $trans['totalValue'];
                    }
                } else {
                    if (isset($prevdepositeTrans[$trans['currency']])) {
                        $prevdepositeTrans[$trans['currency']] += $trans['totalValue'];
                    } else {
                        $prevdepositeTrans[$trans['currency']] = $trans['totalValue'];
                    }
                }
            }
            //dd($prevdepositeTrans,$prevwithdrawTrans);


            $prevclienttotalPayment = abs($prevclienttotalPayment->sum('value'));
            $prevsuppliertotalPayment = abs($prevsuppliertotalPayment->sum('value'));
            //$prevBalance[currency()->config('default')] = 0;
            foreach (currency()->getActiveCurrencies() as $currency) {
                $prevBalance[$currency['code']] = ($prevordersCurrency[$currency['code']] ?? 0) + ($prevdepositeTrans[$currency['code']] ?? 0);

                //  dd($prevordersCurrency[$currency['code']],$prevdepositeTrans[$currency['code']]);
                if ($currency['code'] == "EGP") {
                    $prevBalance[$currency['code']] += $prevclienttotalPayment;
                    $prevBalance[$currency['code']] -= ($prevpurchases + $prevexpenses + $prevsuppliertotalPayment);
                }
                $prevBalance[$currency['code']] -= $prevwithdrawTrans[$currency['code']] ?? 0;
            }
            //dd($prevBalance);
            /*$prevBalance = $prevorders + $prevdeposite + $prevclienttotalPayment -
                ($prevpurchases + $prevexpenses + $prevwithdraw + $prevsuppliertotalPayment);*/

        }
        if ($to) {
            $bankTransaction->whereRaw("DATE(op_date) <= '{$to}'");
            $orders->whereRaw("DATE(invoice_date) <= '{$to}'");
            $visaOrders->whereRaw("DATE(invoice_date) <= '{$to}'");
            $purchases->whereRaw("DATE(invoice_date) <= '{$to}'");
            $expenses->whereRaw("DATE(created_at) <= '{$to}'");
            $deposite->whereRaw("DATE(created_at) <= '{$to}'");
            $withdraw->whereRaw("DATE(created_at) <= '{$to}'");
            $clienttotalPayment->whereRaw("DATE(transactions.created_at) <= '{$to}'");
            $suppliertotalPayment->whereRaw("DATE(transactions.created_at) <= '{$to}'");

        }
        $orders = $orders->get()->toArray();
        $visaOrders = $visaOrders->get()->toArray();
        //dd($visaOrders);
        $dueOrder[currency()->config('default')] = 0;
        $paid[currency()->config('default')] = 0;
        $visapaid[currency()->config('default')] = 0;
        foreach ($orders as $ord) {
            $dueOrder[$ord['currency']] = $ord['due'];
            $paid[$ord['currency']] = $ord['paid'];
        }
        foreach ($visaOrders as $ord) {
            $visapaid[$ord['currency']] = $ord['paid'];
        }
        //$orders = $paid[currency()->config('default')];
        $purchases = $purchases->sum('paid');
        $expenses = $expenses->sum('value');
        $depositeTrans[currency()->config('default')] = $deposite->sum('value');
        $withdrawTrans[currency()->config('default')] = $withdraw->sum('value');

        //dd($bankTransaction->toSql());
        $currencyTrans = $bankTransaction->get()->toArray();
        //dd($currencyTrans);
        foreach ($currencyTrans as $trans) {
            if ($trans['type'] == 1) {
                if (isset($withdrawTrans[$trans['currency']])) {
                    $withdrawTrans[$trans['currency']] += $trans['totalValue'];
                } else {
                    $withdrawTrans[$trans['currency']] = $trans['totalValue'];
                }
            } else {
                if (isset($depositeTrans[$trans['currency']])) {
                    $depositeTrans[$trans['currency']] += $trans['totalValue'];
                } else {
                    $depositeTrans[$trans['currency']] = $trans['totalValue'];
                }
            }
        }
        //dd($currencyTrans);
        //dd($withdrawTrans);
        //dd($depositeTrans,$withdrawTrans);
        //dd($clienttotalPayment->get());
        $clienttotalPayment = abs($clienttotalPayment->sum('value'));
        //dd($suppliertotalPayment->get());
        $suppliertotalPayment = abs($suppliertotalPayment->sum('value'));
        foreach (currency()->getActiveCurrencies() as $currency) {
            $todayBalance[$currency['code']] = ($paid[$currency['code']] ?? 0) + ($depositeTrans[$currency['code']] ?? 0);
            if ($currency['code'] == "EGP") {
                $todayBalance[$currency['code']] += $clienttotalPayment;
                $todayBalance[$currency['code']] -= ($purchases + $expenses + $suppliertotalPayment);
            }
            $todayBalance[$currency['code']] -= $withdrawTrans[$currency['code']] ?? 0;
        }
        /*$todayBalance = $orders+$clienttotalPayment+$deposite-
                        ($withdraw+$purchases+$expenses+$suppliertotalPayment);*/
        return view('dailyreport', compact('visapaid', 'paid', 'dueOrder', 'prevBalance', 'todayBalance', 'clienttotalPayment', 'suppliertotalPayment', 'expenses', 'orders', 'purchases', 'depositeTrans', 'withdrawTrans'));
    }

    public function getCashMoney()
    {
        $banksIds = auth()->user()->treasury()->pluck('id')->toArray();
        $banks = Bank::query()->wherein('id', $banksIds)->selectRaw('sum(balance) as totalBalance')->first();
        $money = $banks->totalBalance ?? 0;
        return $money;
    }

    public function gprofit(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $userTreaury = auth()->user()->treasury_id;
        $orders = Order::where('invoice_type', 'sales')
            ->where('bank_id', $userTreaury)
            ->whereRaw('paid > total/4');
        $generalExpenses = Expense::where('bank_id', $userTreaury)
            ->whereNull('partner_id');
        $ordersProfit = 0;
        if ($from) {
            $orders->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
            $generalExpenses->whereRaw("DATE(created_at) >= '{$from}'");
        }
        if ($to) {
            $orders->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
            $generalExpenses->whereRaw("DATE(created_at) <= '{$to}'");
        }
        $orders = $orders->get();
        $generalExpenses = $generalExpenses->sum('value');
        foreach ($orders as $order) {
            if ($order->paid > $order->total_cost) {
                $ordersProfit += ($order->paid - $order->total_cost);
            }
        }
        $partners = Partner::with('firststore')->get();
        return view('reports.gprofit', compact('ordersProfit', 'generalExpenses', 'partners'));
    }
    public function taswia(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $list = PartnerProfit::query();
        if ($from) {
            $list->whereRaw("DATE(partner_profit.created_at) >= '{$from}'");
        }
        if ($to) {
            $list->whereRaw("DATE(partner_profit.created_at) <= '{$to}'");
        }
        $summery = clone $list;
        $summery->join('partners', function ($q) {
            $q->on('partner_id', '=', 'partners.id');
        });
        $summery = $summery->selectRaw('partners.name,sum(partner_profit.value) as total')->groupBy('partner_id')->get();
        $list = $list->get();

        return view('reports.taswia', compact('list', 'summery'));
    }
    public function profit(Request $req)
    {
        $from = $req->fromdate;
        $to = $req->todate;
        $userStore = auth()->user()->stores()->pluck('stores.id')->toArray();
        $userTreaury = auth()->user()->treasury_id;
        $Transationdiscount = Transaction::query()
            ->join('persons', function ($join) {
                $join->on('persons.id', '=', 'model_id');
                $join->where('persons.type', 'client');
            })
            ->where('note', '=', 'خصم اضافى عند التحصيل');
        $SupplierTransationdiscount = Transaction::query()
            ->join('persons', function ($join) {
                $join->on('persons.id', '=', 'model_id');
                $join->where('persons.type', 'supplier');
            })
            ->where('note', '=', 'خصم اضافى عند التحصيل');
        $taswia = PartnerProfit::query()->orderBy('id', 'DESC')->first();
        $totalProfit = Order::where('invoice_type', 'sales')
            ->where('bank_id', $userTreaury);

        $discounts = Order::where('bank_id', $userTreaury)->where(function ($q) {
            $q->orwhere('commision', '<>', 0);
        });
        $returnDiscounts = ReturnProduct::where('discount', '>', 0);
        $generalExpenses = Expense::where('bank_id', $userTreaury)
            ->whereNull('partner_id');
        $returns = ReturnDetail::join('returns', 'returns.id', '=', 'return_id')
            ->where('return_type', 'sales')
            ->whereIn('store_id', $userStore)
            ->whereNull('deleted_at')
            ->select(DB::raw('sum(qty*price - qty*cost) as totalRetutn'));
        //->groupBy('currency');
        if ($from) {
            $totalProfit->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
            $returns->whereRaw("DATE(returns.created_at) >= '{$from}'");
            $generalExpenses->whereRaw("DATE(created_at) >= '{$from}'");
            $discounts->whereRaw("DATE(created_at) >= '{$from}'");
            $returnDiscounts->whereRaw("DATE(created_at) >= '{$from}'");
            $Transationdiscount->whereRaw("DATE(transactions.created_at) >= '{$from}'");
            $SupplierTransationdiscount->whereRaw("DATE(transactions.created_at) >= '{$from}'");


        }
        if ($to) {
            $totalProfit->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
            $returns->whereRaw("DATE(returns.created_at) <= '{$to}'");
            $generalExpenses->whereRaw("DATE(created_at) <= '{$to}'");
            $discounts->whereRaw("DATE(created_at) <= '{$to}'");
            $returnDiscounts->whereRaw("DATE(created_at) <= '{$to}'");
            $Transationdiscount->whereRaw("DATE(transactions.created_at) <= '{$to}'");
            $SupplierTransationdiscount->whereRaw("DATE(transactions.created_at) <= '{$to}'");


        }
        if ($taswia) {
            $taswiadate = $taswia->created_at->format('Y-m-d');
            $totalProfit->whereRaw("DATE(orders.invoice_date) > '{$taswiadate}'");
            $returns->whereRaw("DATE(returns.created_at) > '{$taswiadate}'");
            $generalExpenses->whereRaw("DATE(created_at) > '{$taswiadate}'");
            $discounts->whereRaw("DATE(created_at) > '{$taswiadate}'");
            $returnDiscounts->whereRaw("DATE(created_at) > '{$taswiadate}'");
            $Transationdiscount->whereRaw("DATE(transactions.created_at) > '{$taswiadate}'");
            $SupplierTransationdiscount->whereRaw("DATE(transactions.created_at) > '{$taswiadate}'");
        }
        $totalProfit = $totalProfit->sum('profit');

        $discountSum = abs($Transationdiscount->sum('value'));
        $suppierdiscountSum = abs($SupplierTransationdiscount->sum('value'));
        $totalProfit += $suppierdiscountSum;
        //dd($discountSum);
        foreach ($discounts->get() as $ord) {
            $discountSum += $ord->commision_egp;
        }
        $totalRetrunDiscount = 0;
        foreach ($returnDiscounts->get() as $ret) {
            if ($ret->discount_type == 1) {
                $totalRetrunDiscount += $ret->discount;
            } else {
                $totalRetrunDiscount += ($ret->total * ($ret->discount / 100));
            }
        }
        //$totalRetrunDiscount = 0;
        //dd($totalProfit, $discountSum, $totalRetrunDiscount);
        $returns = $returns->first();
        $returns = $returns->totalRetutn;
        $generalExpenses = $generalExpenses->sum('value');
        $totalProfit = round($totalProfit, 2);
        //$totalProfit -= ($discountSum+$totalRetrunDiscount+$returns);
        $totalProfit -= ($discountSum + $totalRetrunDiscount);
        $grandProfit = $totalProfit - $generalExpenses;
        $partners = Partner::join('partner_stores', function ($q) use ($userStore) {
            $q->on('partners.id', '=', 'partner_id');
            $q->whereIn('store_id', $userStore);
        })
            ->with(['expenses', 'partnerprofit'])
            ->select(['partners.id', 'name', 'percent'])
            ->groupBy('partners.id')
            ->get();
        /*$partners = DB::table('partner_stores')
                            ->join('partners','partners.id','=','partner_id')
                            ->whereIn('store_id',$userStore)
                            ->select('partners.name','percent')
                            ->get();*/
        return view('reports.profit', compact('totalProfit', 'grandProfit', 'partners', 'generalExpenses'));
    }
    /*
        public function sync(Request $req){
            $url = Setting::findByKey('onlineurl');
            if($url){
                if($req->isMethod('post')){
                    $file = $req->file;
                    \File::put(storage_path(). '/database.sqlite' , $file);
                    return 'done';
                }else{
                    $client = new \GuzzleHttp\Client();
                    $apiUrl = $url."/sync";
                    try {
                        $fileContent = \File::get(storage_path("database.sqlite"));
                        $res = $client->post(
                            $apiUrl,
                            ['form_params' => ['file'=>$fileContent]]
                        );

                        $response = $res->getBody();

                        dd($response);
                        return back()->with('alert-success', 'Data was successfully synchronized');
                    } catch(\Exception $e) {
                        return back()->with('alert-error', 'Error Occurred During Sync');
                        dd($e->getMessage()) ;
                    }
                }

            }
        }*/
    public function sync(Request $req)
    {
        $url = Setting::findByKey('onlineurl');
        if ($url) {
            try {
                if ($req->isMethod('post')) {
                    $state = false;
                    if ($file = $req->file('file')) {
                        $state = $file->storeAs('', 'database.sqlite', ['disk' => 'local']);
                    }
                    return $state;
                } else {
                    $client = new \GuzzleHttp\Client();
                    $apiUrl = $url . "/sync";
                    $response = $client->post(url($apiUrl), [
                        'multipart' => [
                            [
                                'name' => 'file',
                                'contents' => file_get_contents(storage_path("database.sqlite")),
                                'filename' => 'database.sqlite'
                            ]
                        ],
                    ]);
                    $result = $response->getBody()->getContents();
                    if ($result) {
                        return back()->with('alert-success', 'Data was successfully synchronized');
                    } else {
                        return back()->with('alert-error', 'Error Occurred During Sync');
                    }
                }
            } catch (\Exception $e) {
                return back()->with('alert-error', 'Error Occurred');
                dd($e->getMessage());
            }
        }

    }
    public function closeshift(Request $request)
    {
        $usertresury = auth()->user()->treasury;
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                $inputs = $request->except('_token');
                $usertresury->balance -= $inputs['value'];
                $usertresury->save();
                $withdraw = $inputs;
                $withdraw['type'] = 1;
                $withdraw['transactionable_type'] = Bank::class;
                $withdraw['transactionable_id'] = $usertresury->id;
                $withdraw['bank_id'] = $usertresury->id;
                BankTransaction::create($withdraw);
                if ($inputs['bank_id']) {
                    $bank = Bank::find($inputs['bank_id']);
                    $balance = $bank->balance;
                    $bank->balance += $inputs['value'];
                    $bank->save();
                    $inputs['note'] = "ترحيل الوردية من " . $usertresury->name;
                    $inputs['type'] = 2;
                    $inputs['transactionable_type'] = Bank::class;
                    $inputs['transactionable_id'] = $bank->id;
                    $inputs['total'] = $balance;
                    $inputs['due'] = $bank->balance;
                    BankTransaction::create($inputs);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e->getMessage());
                return back()->with('alert-error', 'Error Occurred');
            }
            return back()->with('alert-success', 'Shift was Closed Succssfuly');
        }
        $cash = $usertresury->balance;
        $banks = Bank::where('id', '<>', $usertresury->id)->get();
        return view('closeshift', compact('cash', 'banks'));
    }

    public function importProduct()
    {
        //DB::table('products')->truncate();
        //DB::table('persons')->truncate();
//        Person::create(["name"=>"عميل كاش",'type'=>'client','priceType'=>'one']);
//        Person::create(["name"=>"مورد كاش",'type'=>'supplier','priceType'=>'one']);
        $file = public_path('pstor.xls');
        Excel::import(new ProductsImport(), $file);

        $file = public_path('clients.xls');
        Excel::import(new ClientsImport(), $file);

        $file = public_path('suppliers.xls');
        Excel::import(new SuppliersImport(), $file);

        return redirect('/')->with('success', 'تم إستيراد الأصناف من ملف الإكسل');
    }
}