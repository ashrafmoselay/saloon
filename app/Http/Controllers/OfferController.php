<?php

namespace App\Http\Controllers;

use App\Bank;
use App\OfferDetail;
use App\Person;
use App\Offer;
use App\Setting;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OfferController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('offers.index');
        } else {
            return $this->getData();
        }
    }

    public function getData()
    {
        $list = Offer::query()
            ->orderBy('id', 'DESC')
            ->with('client');
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
            ->addColumn('actions', function ($order) use ($currentUser) {
                $btn = "";
                if ($currentUser->can('edit OfferController')) {
                    $btn .= '<a href="' . route('offers.edit', $order) . '" class="btn btn-primary btn-xs">
                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                    </a>';
                }
                if ($currentUser->can('show OfferController')) {
                    $btn .= ' <a data-toggle="modal" data-target="#addPersonModal" href="' . route('offers.show', $order) . '" class="btn btn-warning btn-xs">
                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                </a> <a class=" btn btn-success btn-xs print-window" href="' . route('offers.getPrint', $order->id) . '" target="_blank"
                role="button">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                            </a>';
                }
                if ($currentUser->can('destroy OfferController')) {
                    $btn .= ' <a class="btn btn-xs btn-danger remove-record" data-toggle="modal" data-url="' . route('offers.destroy', $order) . '" data-id="' . $order->id . '" data-target="#custom-width-modal">
                    <i class="fa fa-trash"></i>
                    </a>';
                }


                return $btn;
            });
        $datatable->rawColumns(['actions', 'clientname']);
        return $datatable->make(true);
        ;
    }


    public function create()
    {
        $order = new Offer;
        return view('offers.create', compact('order'));
    }


    public function store(Request $request)
    {

        $inputs = $request->except('_token');
        try {
            DB::beginTransaction();
            $inputs['order']['creator_id'] = auth()->user()->id;
            $inputs['order']['invoice_date'] = date('Y-m-d');
            $inputs['order']['discount_type'] = isset($inputs['order']['discount_type']) ? 2 : 1;
            $inputs['order']['bank_id'] = auth()->user()->treasury_id;
            $order = Offer::create($inputs['order']);
            foreach ($inputs['product'] as $pitem) {
                $pitem['order_id'] = $order->id;
                OfferDetail::create($pitem);
            }
            DB::commit();
            $route = route('offers.index');
            $request->session()->flash('alert-success', 'تم إضافة الفاتورة بنجاح');
            if(isset($inputs['savePrint']) && $inputs['savePrint']=='print'){
                $route = route('offers.getPrint',$order->id);
            }
            return redirect($route);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء اضافة الفاتورة ' . $e->getMessage());

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
        $order = Offer::find($id);
        return view("offers.show", compact('order'));
    }


    public function getPrint($id)
    {
        $order = Offer::find($id);

        return view("offers.print_invoice", compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Offer::find($id);
        return view('offers.edit', compact('order'));
    }


    public function destroy($id)
    {
        $order = Offer::find($id);
        if ($order->delete()) {
            return "done";
        }
        return "failed";
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Offer::find($id);
        $inputs = $request->except('_token');
        try {
            DB::beginTransaction();
            $inputs['order']['discount_type'] = isset($inputs['order']['discount_type']) ? 2 : 1;
            $order->fill($inputs['order'])->save();
            $order->details()->detach();

            foreach ($inputs['product'] as $pitem) {
                $pitem['order_id'] = $order->id;
                OfferDetail::create($pitem);
            }
            DB::commit();
            $route = route('offers.index');
            $request->session()->flash('alert-success', 'تم تعديل الفاتورة بنجاح');
            if (isset($inputs['savePrint']) && $inputs['savePrint'] == 'print') {
                $route = route('offers.getPrint', $order->id);
            }
            return redirect($route);
        } catch (\Exception $e) {
            DB::rollback();
            dd($inputs, $e->getMessage());
            return back()->withInput($inputs)->with('alert-danger', ' حدث خطأ اثناء تعديل الفاتورة ' . $e->getMessage());
        }
    }

}