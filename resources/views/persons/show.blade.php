@extends('layouts.app')
@section('title', trans('front.summary') . ' ' . $person->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.summary')
            <small>
                {{ $person->name }}
            </small>
            <a onclick="window.print();" href="javascript:void(0)" class=" btn btn-lg print pull-right"><i class="fa fa-print"
                    aria-hidden="true"></i></a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('layouts.partial.printHeader', ['showCompanyData' => true])
        @include('layouts.partial.filter')
        {{-- @include('layouts.partial.printHeader',['showCompanyData'=>true]) --}}
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr class="warning">
                                <td>#</td>
                                <td>{{ $person->id }}</td>
                                <td>@lang('front.name')</td>
                                <td>{{ $person->name }}</td>
                            </tr>
                            <tr class="active">
                                <td>@lang('front.address')</td>
                                <td>{{ $person->address }} - {{ optional($person->region)->name }}</td>
                                <td>@lang('front.mobile')</td>
                                <td>
                                    {{ $person->mobile }}
                                    {{ $person->mobile2 ? '-' . $person->mobile2 : '' }}
                                </td>
                            </tr>
                            <tr class="danger">
                                <td>@lang('front.total')</td>
                                <td>
                                    @php
                                        $totaltra = $orders->sum('total');
                                        if ($sales_returns) {
                                            $totaltra -= abs($sales_returns->sum('return_value'));
                                        }
                                        
                                    @endphp
                                    {{ currency(round($totaltra, 2), currency()->config('default'), currency()->getUserCurrency(), true) }}
                                    <br /><br /><span class="bg-success">إجمالى الفواتير - إجمالى المرتجعات</span>
                                </td>
                                <td>@lang('front.due')</td>
                                <td>
                                    {!! $person->balnce_text !!}
                                </td>
                            </tr>
                            <tr class="info">
                                <td>@lang('front.date')</td>
                                <td colspan="3">{{ $person->created_at }}</td>
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h4>كشف الحساب</h4>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-bordered textceneter">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>البيان</th>
                                                    <th>التاريخ</th>
                                                    <th>دائن</th>
                                                    <th>مدين</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transactions as $perTrans)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $perTrans->note }}</td>
                                                        <td>
                                                            {{ $perTrans->updated_at ? $perTrans->updated_at->format('Y-m-d h:i A') : '' }}
                                                        </td>
                                                        <td>{{ $perTrans->value < 0 ? number_format(abs($perTrans->value), 2) : '------' }}
                                                        </td>
                                                        <td>{{ $perTrans->value > 0 ? number_format($perTrans->value, 2) : '------' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (true || $person->remember_review_balance)
                            <hr>
                            <div class="row hidden-print">
                                <div class="col-md-12">
                                    <form id="personForm" action="{{ route('persons.support', $person) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="box box-primary">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>@lang('front.title')</label>
                                                            <textarea class="form-control" name="comment"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div style="padding-top: 10px;" class="col-md-3">
                                                        <div class="form-group">
                                                            <label>ذكرنى بمراجعة الحساب</label>
                                                            <input name="remember_review_balance"
                                                                @if ($person->remember_review_balance) checked @endif
                                                                type="checkbox" class="flat-red ">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input readonly name="remember_date" type="text"
                                                                value="{{ $person->remember_date ?: '' }}" id="datepicker"
                                                                class="form-control">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input placeholder="@lang('front.address')"
                                                                value="{{ $person->address }}" name="address"
                                                                type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">

                                                            <select name="region_id" class="form-control selectRegion"
                                                                style="width: 100%;">
                                                                <option value="">@lang('front.select region')</option>
                                                                @foreach (\App\Region::get() as $region)
                                                                    <option
                                                                        {{ $region->id == $person->region_id ? 'selected' : '' }}
                                                                        value="{{ $region->id }}">{{ $region->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
                                            </div>
                                        </div>
                                    </form>
                                    @if (count($person->support))
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('front.Employee')</th>
                                                    <th>@lang('front.title')</th>
                                                    <th>@lang('front.Date')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($person->support as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ optional($item->user)->name }}</td>
                                                        <td>{{ $item->comment }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <hr />

                        @if (auth()->user()->can('getSales OrdersController'))
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td colspan="12">@lang('front.invoices')</td>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>المستخدم</th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.invoicenumber')</th>
                                        <th>@lang('front.payment')</th>
                                        <th>@lang('front.total')</th>
                                        <th>الخصم</th>
                                        <th>@lang('front.paid')</th>
                                        <th>@lang('front.due')</th>
                                        <th>@lang('front.status')</th>
                                        <th>@lang('front.Withdrawals')</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalDiscount = 0;
                                    @endphp
                                    @foreach ($orders as $order)
                                        @php
                                            $totalDiscount += $order->dicount_value;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($order->creator)->name }}</td>
                                            <td>{{ $order->invoice_date }}</td>
                                            <td>{{ $order->invoice_number }}</td>
                                            <td>{{ trans('app.' . $order->payment_type) }}</td>
                                            <td>{{ $order->total }}</td>
                                            <td>{{ $order->dicount_value }}</td>
                                            <td>{{ $order->paid }}</td>
                                            <td>{{ $order->due }}</td>
                                            <td>
                                                @if ($order->status)
                                                    <button href="#" type="button" class="btn btn-sm btn-success"><i
                                                            class="fa  fa-check"></i></button>
                                                @else
                                                    <a href="#" type="button" class="btn btn-sm btn-success"><i
                                                            class="fa fa-times"></i></a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->is_withdrawable)
                                                    <button type="button" class="btn btn-sm btn-success"><i
                                                            class="fa fa-check"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-times"></i></button>
                                                @endif
                                            </td>
                                            <td class="actions">
                                                <a data-toggle="modal" data-target="#myModal"
                                                    href="{{ route('orders.show', $order) }}"
                                                    class="btn btn-warning btn-xs">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                </a>
                                                @if (auth()->user()->can('edit OrdersController'))
                                                    <a href="{{ route('orders.edit', $order) }}"
                                                        class="btn btn-primary btn-xs">
                                                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-danger">
                                        <td colspan="5">الإجمالى</td>
                                        <td>{{ $orders->sum('total') }}</td>
                                        <td>{{ $totalDiscount }}</td>
                                        <td>{{ $orders->sum('paid') }}</td>
                                        <td colspan="4">{{ $orders->sum('due') }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            @php
                                $totalPayment = 0;
                                $personTrans = $transactions
                                    ->where('value', '<', 0)
                                    ->where('note', '<>', 'فرق متبقى الفاتورة')
                                    ->where('note', '<>', 'رصيد أول المدة')
                                    ->where('note', '<>', ' خصم قيمة مرتجعات من الحساب ');
                            @endphp
                            @if (count($personTrans))
                                <hr>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td colspan="7">
                                                التحصيلات
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>المستخدم</th>
                                            <th>المندوب</th>
                                            <th>@lang('front.date')</th>
                                            <th>@lang('front.value')</th>
                                            <th>@lang('front.title')</th>
                                            <th class="no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($personTrans as $trans)
                                            @php
                                                $absValue = abs($trans->value);
                                                $totalPayment += $absValue;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ optional($trans->creator)->name }}</td>
                                                <td>{{ optional($trans->sale)->name }}</td>
                                                <td>{{ $trans->getOriginal('created_at') ? $trans->created_at->format('Y-m-d h:i A') : $trans->updated_at }}
                                                </td>
                                                <td>{{ $absValue }}</td>
                                                <td>{{ $trans->note }}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger remove-record"
                                                        data-url="{{ route('transaction.destroy', $trans->id) }}"
                                                        data-id="{{ $trans->id }}">
                                                        <i class="fa fa-trash"></i>
                                                        @lang('front.delete')
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-primary">
                                            <td>الإجمالى</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $totalPayment }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif

                            @php
                                $personTrans2 = $transactions->where('value', '>', 0)->where('note', '<>', 'فرق متبقى الفاتورة');
                            @endphp

                            @if ($personTrans2)
                                <hr />
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td colspan="5">المعاملات النقدية</td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.date')</th>
                                            <th>@lang('front.value')</th>
                                            <th>@lang('front.title')</th>
                                            <th class="no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($personTrans2 as $trans)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $trans->getOriginal('created_at') ? $trans->created_at->format('Y-m-d h:i A') : $trans->updated_at }}
                                                </td>
                                                <td>{{ abs($trans->value) }}</td>
                                                <td>{{ $trans->note }}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger remove-record"
                                                        data-url="{{ route('transaction.destroy', $trans->id) }}"
                                                        data-id="{{ $trans->id }}">
                                                        <i class="fa fa-trash"></i>
                                                        @lang('front.delete')
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-primary">
                                            <td colspan="2">الاجمالى</td>
                                            <td colspan="3">{{ $personTrans2->sum('value') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif

                            @if (count($sales_returns))
                                <hr>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td colspan="5">@lang('front.ordersreturns')</td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.date')</th>
                                            <th>@lang('front.value')</th>
                                            <th>@lang('front.payment')</th>
                                            <th class="no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales_returns as $return)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $return->return_date }}</td>
                                                <td>{{ $return->return_value }}</td>
                                                <td>
                                                    {{ $return->is_cash ? trans('front.cash') : trans('front.from previous balance') }}
                                                </td>
                                                <td class="actions">
                                                    <a data-toggle="modal" data-target="#myModal"
                                                        href="{{ route('returns.show', $return) }}"
                                                        class="btn btn-warning btn-xs">
                                                        <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                        @lang('front.show')
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-blue">
                                            <td colspan="2">
                                                الإجمالى
                                            </td>
                                            <td>{{ $sales_returns->sum('return_value') }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif

                            @if (count($purchase_returns))
                                <hr>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td colspan="5">
                                                @lang('front.purchasereturns')
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.date')</th>
                                            <th>@lang('front.value')</th>
                                            <th>@lang('front.payment')</th>
                                            <th class="no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase_returns as $return)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $return->return_date }}</td>
                                                <td>{{ $return->return_value }}</td>
                                                <td>
                                                    {{ $return->is_cash ? trans('front.cash') : trans('front.from previous balance') }}
                                                </td>
                                                <td class="actions">
                                                    <a data-toggle="modal" data-target="#myModal"
                                                        href="{{ route('returns.show', $return) }}"
                                                        class="btn btn-warning btn-xs">
                                                        <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                        @lang('front.show')
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-danger">
                                            <td colspan="2">@lang('front.total')</td>
                                            <td colspan="3">{{ $purchase_returns->sum('return_value') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                            @if (count($person->totalٌReturn))
                                @php
                                    $returnproductArr = [];
                                @endphp
                                @foreach ($person->totalٌReturn as $order)
                                    @php
                                        $returnproductArr[$order->product_id] = $order->sum;
                                    @endphp
                                @endforeach
                            @endif
                            @if (count($person->totalProduct))
                                <hr>
                                <table class="table table-bordered table-striped hidden-print">
                                    <thead>
                                        <tr>
                                            <td colspan=3">@lang('front.orderdetails')</td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.product')</th>
                                            <th>@lang('front.Total sales')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalQty = 0;
                                        @endphp
                                        @foreach ($person->totalProduct as $order)
                                            @php
                                                $qty = isset($returnproductArr[$order->product_id]) ? $order->sum - $returnproductArr[$order->product_id] : $order->sum;
                                                $totalQty += $qty;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->product->name }}</td>
                                                <td>{{ $qty }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-red">
                                            <td colspan="2"></td>
                                            <td>{{ $totalQty }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
@push('css')
    <style>
        @media print {
            @if ($settings['printerType'] == 'A5')
                table {
                    max-width: 19cm !important;
                    width: 19cm !important;
                }
            @elseif($settings['printerType'] == 'A4')
                .row,
                .col-md-12,
                table {
                    max-width: 28cm !important;
                    width: 28cm !important;
                }
            @endif
            html,
            body {
                height: 100vh;
                width: 100vh;
                margin: 0px !important;
                padding-right: 5px !important;
                /*overflow: hidden;*/
            }
        }

        .textceneter td,
        .textceneter thead tr th {
            border: 1px solid black !important;
            text-align: center !important;
        }

        thead tr th {
            font-weight: bold !important;
        }
    </style>
@endpush
@push('js')
    <script>
        $('#datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{ \Session::get('locale') }}",

        });
    </script>
@endpush
