<?php
namespace App\Http\Controllers;
use App\Bank;
use App\BankTransaction;
use App\Expense;
use App\ExpensesType;
use App\Order;
use App\ReturnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{

    public function index()
    {
        $type_id = request('type');
        $tresury = auth()->user()->treasury->id;
        if($type_id){
            if($type_id=='all'){
                $expenses = Expense::query();
                $from = request()->fromdate;
                $to = request()->todate;
                if($from){
                    $expenses->whereRaw("DATE(created_at) >= '{$from}'");
                }
                if($to) {
                    $expenses->whereRaw("DATE(created_at) <= '{$to}'");
                }

                $expenses= $expenses->where('bank_id',$tresury)->latest()->get();
                $title = 'كل المصروفات';
            }else{
                $type = ExpensesType::find($type_id);
                $title = $type->name;

                $expenses = Expense::where('bank_id',$tresury)->where('expenses_type_id',request('type'))->latest()->get();
            }
            return view('expenses.list',compact('expenses','title'));
        }
        $expenses = Expense::query();
        $from = request()->fromdate;
        $to = request()->todate;
        if($from){
            $expenses->whereRaw("DATE(expenses.created_at) >= '{$from}'");
        }
        if($to) {
            $expenses->whereRaw("DATE(expenses.created_at) <= '{$to}'");
        }
        $expenses = $expenses->join('expenses_type',function($qry){
            $qry->on('expenses_type.id','=','expenses_type_id');
        })->select(DB::raw('expenses_type.id,expenses_type.name,sum(value) as total'))
            ->groupBy('expenses_type.id')
            ->where('bank_id',$tresury)
            ->get();
        return view('expenses.index',compact('expenses'));
    }

    public function report()
    {
        $list = Expense::query();
        $from = request()->fromdate;
        $to = request()->todate;
        if($from){
            $list->whereRaw("DATE(created_at) >= '{$from}'");
        }
        if($to) {
            $list->whereRaw("DATE(created_at) <= '{$to}'");
        }
        $list = $list->get();
        return view('expenses.report',compact('list'));
    }

    public function generaltaxreturnreport(){
        $orders = Order::query();
        $orders->select(DB::raw('invoice_type,sum(total-tax_value) as totalWithotTax,sum(total) as grandTotal,sum(tax_value) as totalTaxValue'));
        $orders->groupBy('invoice_type');

        $returns = ReturnProduct::query();
        $returns->select(DB::raw('sum(total-tax_value) as totalWithotTax,sum(total) as grandTotal,sum(tax_value) as totalTaxValue'));
        $returns->where('return_type','sales');


        $expenses = Expense::query();
        $expenses->select(DB::raw('sum(value-tax_value) as totalWithotTax,sum(value) as grandTotal,sum(tax_value) as totalTaxValue'));


        $from = request('fromdate');
        $to = request('todate');
        if (!empty($from)) {
            $orders->whereRaw("DATE(invoice_date) >= '{$from}'");
            $expenses->whereRaw("DATE(created_at) >= '{$from}'");
            $returns->whereRaw("DATE(return_date) >= '{$from}'");
        }
        if (!empty($to)) {
            $orders->whereRaw("DATE(invoice_date) <= '{$to}'");
            $expenses->whereRaw("DATE(created_at) <= '{$to}'");
            $returns->whereRaw("DATE(return_date) <= '{$to}'");
        }
        $orders = $orders->get();
        $sales = $orders->where('invoice_type','sales')->first();
        $purchases = $orders->where('invoice_type','purchase')->first();
        $expenses = $expenses->first();
        $returns = $returns->first();
        $list = [
            [
                'bcolor'=>'box-warning',
                'title'=>'المشتريات',
                'values'=>[
                    [
                        'name'=>'إجمالي المشتريات بدون الضريبة',
                        'value'=>$purchases['totalWithotTax']??0
                    ],
                    [
                        'name'=>'إجمالي ضريبة المشتريات',
                        'value'=>$purchases['totalTaxValue']??0
                    ],
                    [
                        'name'=>'إجمالي المشتريات مع الضريبة',
                        'value'=>$purchases['grandTotal']??0
                    ],
                ]
            ],
            [
                'bcolor'=>'box-success',
                'title'=>'المبيعات',
                'values'=>[
                    [
                        'name'=>'إجمالي المبيعات بدون الضريبة',
                        'value'=>$sales['totalWithotTax']??0
                    ],
                    [
                        'name'=>'إجمالي ضريبة المبيعات',
                        'value'=>$sales['totalTaxValue']??0
                    ],
                    [
                        'name'=>'إجمالي المبيعات مع الضريبة',
                        'value'=>$sales['grandTotal']??0
                    ],
                ]
            ],
            [
                'bcolor'=>'box-info',
                'title'=>'المصروفات',
                'values'=>[
                    [
                        'name'=>'إجمالي المصروفات بدون الضريبة',
                        'value'=>$expenses['totalWithotTax']??0
                    ],
                    [
                        'name'=>'إجمالي ضريبة المصروفات',
                        'value'=>$expenses['totalTaxValue']??0
                    ],
                    [
                        'name'=>'إجمالي المصروفات مع الضريبة',
                        'value'=>$expenses['grandTotal']??0
                    ],
                ]
            ],
            [
                'bcolor'=>'box-danger',
                'title'=>'مرتجع المبيعات',
                'values'=>[
                    [
                        'name'=>'إجمالي مرتجع المبيعات بدون الضريبة',
                        'value'=>$returns['totalWithotTax']??0
                    ],
                    [
                        'name'=>'إجمالي ضريبة مرتجع المبيعات',
                        'value'=>$returns['totalTaxValue']??0
                    ],
                    [
                        'name'=>'إجمالي مرتجع المبيعات مع الضريبة',
                        'value'=>$returns['grandTotal']??0
                    ],
                ]
            ],
        ];

        $finalTotalTax = $list[1]['values'][1]['value'] - $list[0]['values'][1]['value'];
        $finalTotalTax -= ($list[2]['values'][1]['value'] + $list[3]['values'][1]['value']);
        return view('reports.generaltaxreturnreport',compact('list','finalTotalTax'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $expense = new Expense;
        $employee_id = $request->employee_id;
        return view('expenses.create',compact('expense','employee_id'));
    }

    /**
     * Expense a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $inputs["creator_id"] = auth()->user()->id;
        $expense = Expense::create($inputs);
        $bankId = $request->bank_id;
        // activity()
        //     ->performedOn($expense)
        //     ->log("إضافة مصروف بقيمة ".$expense->value);
        if ($bankId) {
            $trans["bank_id"] = $bankId;
            $bank = Bank::find($bankId);
            $trans["op_date"] = date('Y-m-d');
            $trans["total"] = $bank->balance;
            $grand = currency($inputs['value'], currency()->getUserCurrency(), $bank->currency, $format = false);
            $note = 'المصروفات  | ' . $request->note;
            $trans["due"] = $bank->balance - $grand;
            $bank->balance -= $grand;
            $trans["type"] = "1";
            $trans["note"] = $note;
            $trans["value"] = $grand;
            $bank->save();
            $expense->transaction()->create($trans);
        }
        return redirect(route('expenses.index'))->with('alert-success', trans('front.Successfully added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.show',compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $employee_id = $expense->employee_id;
        return view('expenses.edit',compact('expense','employee_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $inputs = $request->except('_token');
        if($inputs['employee_id']){
            $inputs['partner_id'] = null;
        }
        $expense->update($inputs);
        $bankId = $request->bank_id;
        if ($bankId) {
            $oldtrans = $expense->transaction;
            if($oldtrans){
                $oldtrans->bank->balance += $oldtrans->getOriginal('value');
                $oldtrans->bank->save();
            }
            $trans["bank_id"] = $bankId;
            $bank = Bank::find($bankId);
            $trans["op_date"] = date('Y-m-d');
            $trans["total"] = $bank->balance;
            $grand = currency($inputs['value'], currency()->getUserCurrency(), $bank->currency, $format = false);
            $note = 'المصروفات  | ' . $request->note;
            $trans["due"] = $bank->balance - $grand;
            $bank->balance -= $grand;
            $trans["type"] = "1";
            $trans["note"] = $note;
            $trans["value"] = $grand;
            $bank->save();
            $expense->transaction()->update($trans);
        }
        return redirect(route('expenses.index'))->with('alert-success', trans('front.Modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $oldtrans = $expense->transaction;
        if($oldtrans){
            $bankId = $oldtrans->bank->id;
            $trans["bank_id"] = $bankId;
            $bank = Bank::find($bankId);
            $trans["op_date"] = date('Y-m-d');
            $trans["total"] = $bank->balance;
            $grand = $oldtrans->getOriginal('value');
            $note = 'مسح المصروف | '.$expense->note;
            $trans["due"] = $bank->balance - $grand;
            $bank->balance += $grand;
            $trans["type"] = "2";
            $trans["note"] = $note;
            $trans["value"] = $grand;
            $bank->save();
            $expense->transaction()->create($trans);

            $oldtrans->delete();
        }
        if($expense->delete()){
            return "done";
        }
        return "failed";
    }


}
