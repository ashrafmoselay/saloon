<?php
namespace App\Http\Controllers;
use App\Employee;
use App\EmployeePunishmentReward;
use App\Order;
use App\Person;
use App\ReturnProduct;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    public function index()
    {
        $employees = Employee::latest()->get();
        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee;
        return view('employees.create',compact('employee'));
    }

    /**
     * Employee a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        Employee::create($inputs);
        return redirect(route('employees.index'))->with('alert-success', trans('front.Successfully added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $from = $request->fromdate;
        $to = $request->todate;
        //dd($from);
        $employee = Employee::findOrFail($id);
       // dd($employee->paymentsTransactions);
        //\DB::enableQueryLog();
        $listOrders = $employee->managerOrders()->paginate();

        //dd($employee->managerOrders()->sum('total'));
        $employee->load(
            [
            'managerOrders'=>function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
                }
                return $query;
            },
            'mtotalProduct' => function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
                }
                return $query;
            },
            'mtotalٌReturn' => function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(returns.return_date) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(returns.return_date) <= '{$to}'");
                }
                return $query;
            },
            'totalProduct' => function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
                }
                return $query;
            },
            'totalٌReturn' => function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(returns.return_date) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(returns.return_date) <= '{$to}'");
                }
                return $query;
            },'saleOrders' => function($query)use($from,$to){
            if($from) {
                $query->whereRaw("DATE(invoice_date) >= '{$from}'");
            }
            if($to) {
                $query->whereRaw("DATE(invoice_date) <= '{$to}'");
            }
            $query->orderBy('invoice_date','ASC');
            return $query;
        },'saleReturnsOrder' => function($query)use($from,$to){
            if($from) {
                $query->whereRaw("DATE(return_date) >= '{$from}'");
            }
            if($to) {
                $query->whereRaw("DATE(return_date) <= '{$to}'");
            }
            return $query;
        },'punishments' => function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(created_at) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(created_at) <= '{$to}'");
                }
                return $query;
            },'paymentsTransactions' => function($query)use($from,$to){
                if($from) {
                    $query->whereRaw("DATE(created_at) >= '{$from}'");
                }
                if($to) {
                    $query->whereRaw("DATE(created_at) <= '{$to}'");
                }
                return $query;
            },'rewards' => function($query)use($from,$to){
            if($from) {
                $query->whereRaw("DATE(created_at) >= '{$from}'");
            }
            if($to) {
                $query->whereRaw("DATE(created_at) <= '{$to}'");
            }
            return $query;
        },'expenses' => function($query)use($from,$to){
            if($from) {
                $query->whereRaw("DATE(created_at) >= '{$from}'");
            }
            if($to) {
                $query->whereRaw("DATE(created_at) <= '{$to}'");
            }
            return $query;
        },'marketProduct' => function($query)use($from,$to){
            if($from) {
                $query->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
            }
            if($to) {
                $query->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
            }
            return $query;
        }, 'totalProduct.product','marketProduct.product','marketProduct.order']);
        //dd($employee->mtotalٌReturn);
        $punishments = $employee->punishments;
        $rewards = $employee->rewards;
        $expenses = $employee->expenses;
        $paymentsTransactions = $employee->paymentsTransactions;
        //$orders = $employee->marketOrders;
        //dd($orders);

        return view('employees.show',compact('paymentsTransactions','employee','punishments','rewards','expenses'));
    }



    public function getSalesManReport(Request $request)
    {
        $from = $request->fromdate;
        $to = $request->todate;
        $list = Employee::query()
                        ->with([
                            'saleOrders' => function($query)use($from,$to){
                                if($from) {
                                    $query->whereRaw("DATE(invoice_date) >= '{$from}'");
                                }
                                if($to) {
                                    $query->whereRaw("DATE(invoice_date) <= '{$to}'");
                                }
                                $query->orderBy('invoice_date','ASC');
                                return $query;
                            },'saleReturnsOrder' => function($query)use($from,$to){
                                if($from) {
                                    $query->whereRaw("DATE(return_date) >= '{$from}'");
                                }
                                if($to) {
                                    $query->whereRaw("DATE(return_date) <= '{$to}'");
                                }
                                return $query;
                            },
                            'paymentsTransactions' => function($query)use($from,$to){
                                if($from) {
                                    $query->whereRaw("DATE(created_at) >= '{$from}'");
                                }
                                if($to) {
                                    $query->whereRaw("DATE(created_at) <= '{$to}'");
                                }
                                return $query;
                            }
                            ])
                        ->where('type','sales')
                        ->get();

        return view('reports.general_sales_man',compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $inputs = $request->except('_token');
        $employee->update($inputs);
        return redirect(route('employees.index'))->with('alert-success', trans('front.Modified successfully'));
    }

    public function addPunishmentsRewards(Request $request, Employee $employee)
    {
        if($request->isMethod('post')){
            $inputs = $request->except('_token');
            $inputs['employee_id'] =$employee->id;
            EmployeePunishmentReward::create($inputs);
            return redirect(route('employees.index'))->with('alert-success', trans('front.Successfully added'));
        }
        return view('employees.punishments_rewards',compact('employee'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if($employee->delete()){
            return "done";
        }
        return "failed";
    }
    public function representativesReport(){
        $persons = Person::join('orders',function ($qry){
                                $qry->on('persons.id','=','client_id');
                                $qry->whereNotNull('sale_id');
                                $qry->whereNull('orders.deleted_at');
                            })
            ->where('is_client_supplier',1)
            ->selectRaw('persons.*,sale_id')
            ->groupBy('client_id')
            ->get();
        $salesP = [];
        foreach ($persons as $p){
            $salesP[$p->sale_id] = $p->balnce_value;
        }
        $list = Order::selectRaw('employees.id,employees.name,sum(due) as totalDept')
            ->join("persons",function($qry){
                $qry->on('persons.id','=','client_id');
                $qry->where('is_client_supplier',0);
                $qry->whereNull('persons.deleted_at');
            })
            ->join("employees",function($qry){
                $qry->on('employees.id','=','sale_id');
                $qry->whereNull('employees.deleted_at');
            })
            ->addSelect(\DB::raw(
                '(select sum(return_value) from returns
                    where return_type = "sales" and returns.sale_id=orders.sale_id)
                     as totalReturn'
            ))
            ->where('invoice_type','sales')
            ->groupBy('sale_id')
            ->having('totalDept','>',0)
            ->get();

        return view('representativesReport',['list'=>$list,'salesP'=>$salesP]);
    }
    public function getRepresentativesDetail(){
        $emp = Employee::find(request('id'))->name;
        $list = Order::selectRaw('persons.*,regions.name as region,sum(due) as totalDept')
            ->join("persons",function($qry){
                $qry->on('persons.id','=','client_id');
                $qry->whereNull('persons.deleted_at');
            })
            ->leftjoin("regions",function($qry){
                $qry->on('regions.id','=','persons.region_id');
            })
            ->where('invoice_type','sales')
            ->where('sale_id',request('id'))
            ->groupBy('client_id')
            ->addSelect(\DB::raw(
                '(select sum(return_value) from returns
                    where return_type = "sales" and sale_id = '.request('id')
                    .' and returns.client_id=orders.client_id) as totalReturn'
            ))
            ->having('totalDept','>',0)
            ->get();
        return view('representative_details',['list'=>$list,'emp'=>$emp]);
    }
    public function representativesSalesReport(Request $req){
        $from = $req->fromdate;
        $to = $req->todate;
        $orders = Order::query();
        if($from){
            $orders->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
        }
        if($to){
            $orders->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
        }
        $list = $orders->selectRaw('employees.id,employees.name,sum(total-discount_value) as totalOrders')
            ->join("employees",function($qry){
                $qry->on('employees.id','=','sale_id');
            })
            ->where('invoice_type','sales')
            ->groupBy('sale_id')
            ->get();
        return view('representativesReport_sales',['list'=>$list]);
    }
    public function getRepresentativesSalesReportDetail(Request $req){
        $emp = Employee::find(request('id'))->name;
        $from = $req->fromdate;
        $to = $req->todate;
        $orders = Order::query();
        if($from){
            $orders->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
        }
        if($to){
            $orders->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
        }
        $list = $orders->where('invoice_type','sales')
            ->where('sale_id',request('id'))
            ->get();
        return view('representative_sales_details',['list'=>$list,'emp'=>$emp]);
    }


    public function getEmployeeList(){
        ini_set('memory_limit', '-1');
        $person_id = request('client_id');
        $employees = Employee::where('name','like','%'.request('q').'%')
            /*->whereHas('saleOrders',function($qry) use($person_id){
                //$qry->where('employees.id','sale_id');
                //$qry->where('invoice_type','sales');
                $qry->where('client_id',$person_id);
            })*/
            ->where('employees.type','sales')
            ->selectRaw('employees.id,name as text')->get();
        return response()->json($employees);
    }


}
