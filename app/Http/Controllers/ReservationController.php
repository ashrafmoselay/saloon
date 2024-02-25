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
use Yajra\DataTables\DataTables;

class ReservationController extends Controller
{
    public function __construct()
    {
        view()->composer(['reservations.*'], function ($view) {
            $statusList = [
                'معلق',
                'جارى العمل',
                'مكتمله',
                'مؤجله'
            ];
            $view->with([
                'statusList' => $statusList,
                'employees' => Employee::pluck('name', 'id'),
                'products' => Product::pluck('name', 'id'),
            ]);
        });
        parent::__construct();
    }
    public function index()
    {
        $calander = $this->getCalandar();
        $calander = json_encode($calander);
        \JavaScript::put([
            'calander' => $calander,
        ]);
        $categories = Category::query()->with(['products', 'products.productUnit'])->get();
        
        return view('reservations.index', compact('categories'));
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
            'معلق' => '#FF9800',
            'جارى العمل' => '#337ab7',
            'مكتمله' => '#008d4c',
            'مؤجله' => '#d73925'
        ];
        foreach ($orderServices as $row) {
            $title = optional($row->employee)->name.' - ';
            $title .= optional(optional($row->order)->client)->name . ' - ';
            $title .= optional($row->product)->name;

            $calander[] =
                [
                    'title' => $title,
                    'start' => $row->serive_datetime,
                    'end' => $row->serive_datetime,
                    'url' => route('reservations.edit', $row->id),
                    'backgroundColor' => $statusList[$row->status] ?? '#FF9800',
                    'borderColor' => $statusList[$row->status] ?? '#FF9800',
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
        $services = Product::where('is_service', 1)->get();
        return view('reservations.edit', compact('row', 'services'));
    }


    public function update(Request $request, $id)
    {
        $row = OrderDetail::find($id);
        $inputs = $request->except('_token');
        //dd($row,$inputs);
        $row->update($inputs);
        return back()->with('alert-success', trans('front.Modified successfully'));
    }


    public function report()
    {
        if (!request()->ajax()) {
            return view('reservations.services');
        } else {
            return $this->getData();
        }
    }

    public function getData()
    {

        $list = OrderDetail::query()->where('unit_id', 'خدمة')->filter()->with('order.client');

        $datatable = DataTables::of($list)
            ->addColumn('invoice_number', function ($row) {
                return optional($row->order)->invoice_number;
            })->addColumn('date', function ($row) {
                return date('Y-m-d h:i A', strtotime($row->serive_datetime));
            })->addColumn('empname', function ($row) {
                return optional($row->employee)->name;
            })->addColumn('clientname', function ($row) {
                return optional(optional($row->order)->client)->name;
            })->addColumn('clientmobile', function ($row) {
                return optional(optional($row->order)->client)->mobile;
            })->addColumn('servicename', function ($row) {
                return optional($row->product)->name;
            })->addColumn('price', function ($row) {
                return $row->price;
            })->addColumn('status', function ($row) {
                $statusList = [
                    'معلق' => '#FF9800',
                    'جارى العمل' => '#337ab7',
                    'مكتمله' => '#008d4c',
                    'مؤجله' => '#d73925'
                ];
                $color = $statusList[$row->status] ?? '#FF9800';
                $name = isset($statusList[$row->status]) ? $row->status : 'معلق';
                return '<a style="color:' . $color . '" class="btn" >' . $name . '</a>';
            })->addColumn('comment', function ($row) {
                return $row->comment;
            });
        $datatable->rawColumns(['status']);
        $datatable = $datatable->with('totalOrder', $list->sum('price'));
        //$clone = clone $list;
        $datatable = $datatable->with('count', $list->count());
        return $datatable->make(true);
    }
}
