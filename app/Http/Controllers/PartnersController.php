<?php
namespace App\Http\Controllers;
use App\CalanderPayment;
use App\Expense;
use App\ExpensesType;
use App\Partner;
use App\PartnerProfit;
use App\Store;
use Illuminate\Http\Request;

class PartnersController extends Controller
{

    public function index()
    {
        $partners = Partner::latest()->get();
        return view('partners.index',compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partner = new Partner;
        $stores = Store::get();
        return view('partners.create',compact('partner','stores'));
    }

    /**
     * Partner a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $partner = Partner::create($inputs);
        $partner->stores()->attach($inputs['store']);
        return redirect(route('partners.index'))->with('alert-success', trans('front.Successfully added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return view('partners.show',compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $stores = $partner->stores()->get();
        $Allstores = Store::get();
        $stores->merge($Allstores);
        if(!count($stores)){
            $stores = Store::get();
        }
        return view('partners.edit',compact('partner','stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $inputs = $request->except('_token');
        $partner->update($inputs);
        $partner->stores()->detach();
        $partner->stores()->attach($inputs['store']);
        return redirect(route('partners.index'))->with('alert-success', trans('front.Modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        if($partner->delete()){
            return "done";
        }
        return "failed";
    }

    public function addProfitToPartner(Request $request)
    {
        $inputs = $request->except('_token');
       // dd($inputs['partner']);
        if(!isset($inputs['grandProfit']) || $inputs['grandProfit'] <= 0){
            return back()->with('alert-danger', 'خطأ لا توجد ارباح لتسويتها');
        }
        foreach($inputs['partner'] as $part){
            if ($part['profit'] !=0 ){
                PartnerProfit::create([
                    'partner_id'=>$part['id'],
                    'value'=>$part['profit'],
                ]);
            }
        }
        return back()->with('alert-success', 'تمت التسوية بنجاح');
    }

}
