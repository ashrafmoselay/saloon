<?php
namespace App\Http\Controllers;
use App\Bank;
use App\BankTransaction;
use Illuminate\Http\Request;

class BanksController extends Controller
{

    public function index()
    {
        $type = request('type')?:1;
        //dd($type);
        if($type==2){
            $banks = auth()->user()->treasury()->get();
        }else{
            $banks = Bank::where('type',$type)->get();
        }
        return view('banks.index',compact('banks','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = request('type')?:1;
        $bank = new Bank;
        return view('banks.create',compact('bank','type'));
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

        $bank = Bank::create($inputs);
        if($inputs['balance']){
            $trans['bank_id'] =$bank->id;
            $trans['op_date'] =date('Y-m-d');
            $trans['value'] =$inputs['balance'];
            $trans['type'] =2;
            $trans['total'] =0;
            $trans['due'] =$inputs['balance'];
            $trans['note'] ='رصيد أول المدة';
            BankTransaction::create($trans);
        }
        return back()->with('alert-success', trans('front.Bank successfully added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        $from = request()->fromdate;
        $to = request()->todate;
        $type = request()->type;
        $transactions = $bank->transactions();
        if($from){
            $transactions->whereRaw("DATE(created_at) >= '{$from}'");
        }
        if($type){
            $transactions->where('type',$type);
        }
        if($to) {
            $transactions->whereRaw("DATE(created_at) <= '{$to}'");
        }
        $transactions = $transactions->get();
        return view('banks.show',compact('bank','transactions'));
    }

        public function banktransaction($id)
        {
            $transaction = BankTransaction::findOrFail($id);
            return view('banks.printtrans',compact('transaction'));
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('banks.edit',compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $inputs = $request->except('_token');
        $bank->update($inputs);
        return back()->with('alert-success', trans('front.The bank has been successfully modified'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        if($bank->delete()){
            return "done";
        }
        return "failed";

    }
    public function addTransaction(Request $request, Bank $bank)
    {
        if($request->isMethod('post')){
            $inputs = $request->except('_token');
            $inputs['bank_id'] =$bank->id;
            $logNote="";
            if($inputs['type']==1){
                $bank->balance -= $inputs['value'];
                $bank->save();
                $logNote="سحب المبلغ ".$inputs['value']." من ".$bank->name;
            }else{
                $bank->balance += $inputs['value'];
                $bank->save();
                $logNote="إيداع المبلغ ".$inputs['value']." الى ".$bank->name;
            }
            $inputs['transactionable_type'] = Bank::class;
            $inputs['transactionable_id'] = $bank->id;
            BankTransaction::create($inputs);
            activity()
                ->performedOn($bank)
                ->log($logNote);
            return back()->with('alert-success', trans('front.Successfully added'));
        }
        return view('banks.transactions',compact('bank'));
    }


}
