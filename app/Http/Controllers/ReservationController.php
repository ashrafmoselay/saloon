<?php

namespace App\Http\Controllers;

use App\Category;
use App\Employee;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index()
    {
        $calander = $this->getCalandar();
        $calander = json_encode($calander);
        \JavaScript::put([
            'calander' => $calander,
        ]);
        $categories = Category::query()->with(['products', 'products.productUnit'])->get();
        $employees = Employee::get();
        return view('reservations.index', compact('categories', 'employees'));
    }
    public function getCalandar()
    {
        $calander = [];

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $orderServices = OrderDetail::whereNotNull('serive_datetime')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();
        $statusList = [
            'معلق'=>'#FF9800',
            'جارى العمل'=>'#337ab7',
            'مكتمله'=>'#008d4c',
            'مؤجله'=>'#d73925'
        ];
        foreach ($orderServices as $row) {
            $title = optional($row->employee)->name;
            $title .= optional(optional($row->order)->client)->name . ' - ';
            $title .= optional($row->product)->name;

            $calander[] =
                [
                    'title' => $title,
                    'start' => $row->serive_datetime,
                    'end' => $row->serive_datetime,
                    'url' => route('reservations.edit', $row->id),
                    'backgroundColor' => $statusList[$row->status]??'#FF9800',
                    'borderColor' => $statusList[$row->status]??'#FF9800',
                    'id' => '',
                    'user' => '',
                    'status' => ''
                ];
        }
        return $calander;
    }

    public function edit($id)
    {
        $row = OrderDetail::find($id);
        $services = Product::where('is_service',1)->get();
        $employees = Employee::get();
        return view('reservations.edit',compact('row','services','employees'));
    }


    public function update(Request $request,$id)
    {
        $row = OrderDetail::find($id);
        $inputs = $request->except('_token');
        //dd($row,$inputs);
        $row->update( $inputs);
        return back()->with('alert-success', trans('front.Modified successfully'));
    }
}
