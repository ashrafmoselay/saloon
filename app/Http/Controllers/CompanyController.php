<?php
namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $q = $request->input('term', '');
            $list = Company::query();
            if($q){
                $list->where('sender_name', 'LIKE', '%'.$q.'%')
                    ->orwhere('sender_mobile', 'LIKE', '%'.$q.'%');
            }
            $list= $list->latest()->take(20)
                ->select(DB::raw("sender_name || ' - ' || sender_mobile AS text"),'id')
                ->get();
            return ['results' => $list];
        }else {
            $companies = Company::latest()->get();
            return view('companies.index', compact('companies'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = new Company;
        $from = \request('fromshipment');
        return view('companies.create',compact('company','from'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only('sender_name','sender_mobile');

        Company::firstOrCreate(['sender_mobile'=>$inputs['sender_mobile']],$inputs);
        if($request->ajax()){
            $companies = Company::latest()->get();
            return view('companies.dropdown',compact('companies'));
        }
        return redirect(route('companies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $inputs = $request->except('_token');
        $company->update($inputs);
        return redirect(route('companies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if($company->delete()){
            return "done";
        }
        return "failed";
    }


}
