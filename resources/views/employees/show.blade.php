@extends('layouts.app')
@section('title', trans('front.summary') . ' ' . $employee->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.summary')
            <small>
                {{ $employee->name }}
            </small>
            <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
                <i class="fa fa-print" aria-hidden="true"></i>
            </a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('layouts.partial.filter')
        @include('layouts.partial.printHeader', ['showCompanyData' => true])

        @if ($employee->type == 'sales_manager')
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-header">
                            <h3 class="box-title"> @lang('front.report')
                                {{ ' | ' . request()->fromdate . ' | ' . request()->todate }}
                            </h3>
                        </div>

                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>إجمالى مبيعات</td>
                                        <td>التارجت</td>
                                        <td>النسبة</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalS = $employee->managerOrders->sum('total');
                                        $percent = 0;
                                        if ($totalS && $employee->target) {
                                            $percent = ($totalS / $employee->target) * 100;
                                            $percent = round($percent, 2);
                                        }
                                    @endphp
                                    <tr class="{{ $totalS > $employee->target || $percent >= 100 ? 'bg-green' : 'bg-danger' }}">
                                        <td>{{ $totalS }}</td>
                                        <td>{{ $employee->target }}</td>
                                        <td>
                                            @if ($totalS && $employee->target)
                                                {{ $percent }}
                                            @endif
                                            %
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($employee->mtotalٌReturn))
                @php
                    $returnproductArr = [];
                @endphp
                @foreach ($employee->mtotalٌReturn as $order)
                    @php
                        $returnproductArr[$order->product_id] = $order->sum;
                    @endphp
                @endforeach
            @endif

            @if (count($employee->mtotalProduct))
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">@lang('front.orderdetails')</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-striped dataTableTT">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.product')</th>
                                            <th>@lang('front.Total sales')</th>
                                            <th class="hide"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtt = 0;
                                            $ttt = 0;
                                        @endphp
                                        @foreach ($employee->mtotalProduct as $order)
                                            @php
                                                $subtt = isset($returnproductArr[$order->product_id]) ? $order->sum - $returnproductArr[$order->product_id] : $order->sum;
                                                //$ttt += $subtt;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ optional($order->product)->name }} </td>
                                                <td>{{ round($subtt, 2) }} {{ $order->unit_name }}</td>
                                                <td class="hide"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('front.orders')</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <table class="table table-bordered  dataTableTT">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المندوب</th>
                                        <th>العميل</th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.invoicenumber')</th>
                                        <th>@lang('front.payment')</th>
                                        <th>@lang('front.total')</th>
                                        <th>@lang('front.paid')</th>
                                        <th>@lang('front.due')</th>
                                        <th>@lang('front.status')</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->managerOrders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->sale_id }}</td>
                                            <td>{{ optional($order->client)->name }}</td>
                                            <td>{{ $order->invoice_date }}</td>
                                            <td>{{ $order->invoice_number }}</td>
                                            <td>{{ !in_array($order->payment_type, ['cash', 'delayed']) ? $order->payment_type : trans('app.' . $order->payment_type) }}
                                            </td>
                                            <td>{{ currency($order->getOriginal('total'), $order->currency, $order->currency, $format = true) }}
                                            </td>
                                            <td>{{ currency($order->getOriginal('paid'), $order->currency, $order->currency, $format = true) }}
                                            </td>
                                            <td>{{ currency($order->getOriginal('due'), $order->currency, $order->currency, $format = true) }}
                                            </td>
                                            <td>
                                                @if ($order->status)
                                                    <button href="#" type="button" class="btn btn-sm btn-success"><i
                                                            class="fa  fa-check"></i></button>
                                                @else
                                                    <a href="#" type="button" class="btn btn-sm btn-success"><i
                                                            class="fa fa-times"></i></a>
                                                @endif
                                            </td>
                                            <td class="actions">
                                                <a data-toggle="modal" data-target="#myModal"
                                                    href="{{ route('orders.show', $order) }}"
                                                    class="btn btn-warning btn-xs">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                    @lang('front.show')
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <td colspan="6">الإجمالى</td>
                                        <td>{{ currency($employee->managerOrders->sum('total'), 'EGP', 'EGP', $format = true) }}
                                        </td>
                                        <td>{{ currency($employee->managerOrders->sum('paid'), 'EGP', 'EGP', $format = true) }}
                                        </td>
                                        <td>{{ currency($employee->managerOrders->sum('due'), 'EGP', 'EGP', $format = true) }}
                                        </td>
                                        <td colspan="2"></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> @lang('front.report')
                                {{ ' | ' . request()->fromdate . ' | ' . request()->todate }}
                            </h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        @if ($employee->type == 'normal')
                                            <td>@lang('front.Salary')</td>
                                        @else
                                            <td class="bg-danger">إجمالى المبيعات</td>
                                            <td>إجمالى تحصيلات</td>
                                            @if (auth()->user()->can('profit HomeController'))
                                                <td class="hideprint">إجمالى الربح</td>
                                            @endif
                                            <td>@lang('front.percentage')</td>
                                            @if (auth()->user()->can('profit HomeController'))
                                                <td class="hideprint">نسبة ع الربح</td>
                                            @endif
                                            <td class="hideprint">النسبة ع المبيعات</td>
                                            <td> @lang('front.Returns')</td>
                                        @endif

                                        <td>@lang('front.discounts')</td>
                                        <td>@lang('front.expenses')</td>
                                        <td>@lang('front.rewards')</td>
                                        <td class="hideprint">الصافى ع المبيعات</td>
                                        <td>الصافي ع الربح</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalpunishments = (int) $punishments->sum('value');
                                        $paymentsTransactions = $paymentsTransactions->sum('value');
                                        $totalexpenses = (int) $expenses->sum('value');
                                        $totalrewards = (int) $rewards->sum('value');
                                        $allorder = 0;
                                        $totalReturns = 0;
                                        $totalSaleReturnsOrder = [];
                                        $grandTotalOrder = 0;
                                        $grandByprofit = 0;
                                        if ($employee->type == 'normal') {
                                            $netSalary = $employee->salary + $totalrewards - ($totalpunishments + $totalexpenses);
                                        } else {
                                            if ($employee->type == 'markter') {
                                                $totalOrder = $employee->marketProduct->groupBy('currency')->map(function ($row) {
                                                    return $row->sum('total');
                                                });
                                            } else {
                                                /*$totalOrder = $employee->saleOrders->groupBy('currency')->map(function ($row) {
                                            return $row->sum('total');
                                        });*/
                                                $orders = $employee
                                                    ->saleOrders()
                                                    ->join('order_detailes', function ($join) {
                                                        $join->on('orders.id', '=', 'order_id');
                                                    })
                                                    ->select(DB::raw('sum( ((qty - return_qty) * price) - ((qty - return_qty) * cost))-discount_value as totalOrder,sum((qty - return_qty) * price)-discount_value as grandTotalOrder'));
                                                $from = request('fromdate');
                                                $to = request('todate');
                                                $employeeOrder = $employee->saleOrders();
                                                if ($from) {
                                                    $orders->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
                                                    $employeeOrder->whereRaw("DATE(orders.invoice_date) >= '{$from}'");
                                                }
                                                if ($to) {
                                                    $orders->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
                                                    $employeeOrder->whereRaw("DATE(orders.invoice_date) <= '{$to}'");
                                                }
                                                $orders = $orders->first();
                                                //dd($orders->totalOrder);
                                                $allorder = $orders->totalOrder ?? 0;
                                                //$allorder-=$sumDiscount;
                                                $grandTotalOrder = $orders->grandTotalOrder ?? 0;
                                                $totalReturns = $employee->saleReturnsOrder->sum('sales_value');
                                            }
                                            //dd($grandTotalOrder);
                                            $orderPercent = $grandTotalOrder * ($employee->percent / 100);
                                            $orderPercent = round($orderPercent, 2);
                                            $profitPercent = $allorder * ($employee->percent / 100);
                                            $profitPercent = round($profitPercent, 2);
                                            $netSalary = $orderPercent + $totalrewards - ($totalpunishments + $totalexpenses);
                                            $allorder = $allorder ? currency($allorder, 'EGP', 'EGP', $format = true) : currency(0, 'EGP', 'EGP', $format = true);
                                            $netSalary -= $totalReturns;
                                            $netSalary = currency($netSalary, 'EGP', 'EGP', $format = true);
                                            $grandTotalOrder = currency($grandTotalOrder, 'EGP', 'EGP', $format = true);
                                            $grandByprofit = $profitPercent + $totalrewards - ($totalpunishments + $totalexpenses);
                                            $grandByprofit -= $totalReturns;
                                            $grandByprofit = currency($grandByprofit, 'EGP', 'EGP', $format = true);
                                        }
                                    @endphp
                                    <tr>
                                        @if ($employee->type == 'normal')
                                            <td> {{ $employee->salary }}</td>
                                        @else
                                            <td class="bg-danger">{{ $grandTotalOrder }}</td>
                                            <td>{{ abs($paymentsTransactions) }}</td>
                                            @if (auth()->user()->can('profit HomeController'))
                                                <td class="hideprint">{{ $allorder }}</td>
                                            @endif
                                            <td>{{ $employee->percent }} %</td>
                                            @if (auth()->user()->can('profit HomeController'))
                                                <td class="hideprint">{{ $profitPercent }}</td>
                                            @endif
                                            <td class="hideprint">{{ currency($orderPercent, 'EGP', 'EGP', $format = true) }}
                                            </td>
                                            <td>{{ currency($totalReturns, 'EGP', 'EGP', $format = true) }}</td>
                                        @endif

                                        <td>{{ $totalpunishments }}</td>
                                        <td>{{ $totalexpenses }}</td>
                                        <td>{{ $totalrewards }}</td>
                                        <td class="hideprint">{{ $netSalary }}</td>
                                        <td>{{ $grandByprofit }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($paymentsTransactions)
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-header">
                            <h3 class="box-title">تحصيلات ومدفوعات المندوب</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المستخدم</th>
                                        <th>العميل</th>
                                        <th>المورد</th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.value')</th>
                                        <th>@lang('front.title')</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPayment = 0;
                                        $totalSupplierPayment = 0;
                                    @endphp
                                    @foreach ($employee->paymentsTransactions as $trans)
                                        @php
                                            $absValue = abs($trans->value);
                                            $person = optional($trans->model);
                                            if ($person->type == 'client') {
                                                $totalPayment += $absValue;
                                            } else {
                                                $totalSupplierPayment += $absValue;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($trans->creator)->name }}</td>
                                            <td>{{ $person->type == 'client' ? $person->name : '' }}</td>
                                            <td>{{ $person->type != 'client' ? $person->name : '' }}</td>
                                            <td>{{ $trans->created_at->format('Y-m-d h:i A') }}</td>
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
                                        <td></td>
                                        <td>
                                            تحصيل: {{ $totalPayment }} <br />
                                            مدفوعات: {{ $totalSupplierPayment }}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (count($employee->totalProduct) && $employee->type == 'sales')

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('front.orders')</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <table class="table table-bordered  dataTableTT">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>العميل</th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.invoicenumber')</th>
                                        <th>@lang('front.payment')</th>
                                        <th>@lang('front.total')</th>
                                        <th>@lang('front.discount')</th>
                                        <th>@lang('front.paid')</th>
                                        <th>@lang('front.due')</th>
                                        <th>@lang('front.status')</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalDiscount = 0;
                                    @endphp
                                    @foreach ($employee->saleOrders as $order)
                                        @php
                                            $totalDiscount += $order->dicount_value;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($order->client)->name }}</td>
                                            <td>{{ $order->invoice_date }}</td>
                                            <td>{{ $order->invoice_number }}</td>
                                            <td>{{ !in_array($order->payment_type, ['cash', 'delayed']) ? $order->payment_type : trans('app.' . $order->payment_type) }}
                                            </td>
                                            <td>{{ currency($order->getOriginal('total'), $order->currency, $order->currency, $format = true) }}
                                            </td>
                                            <td>{{ $order->dicount_value }}</td>
                                            <td>{{ currency($order->getOriginal('paid'), $order->currency, $order->currency, $format = true) }}
                                            </td>
                                            <td>{{ currency($order->getOriginal('due'), $order->currency, $order->currency, $format = true) }}
                                            </td>
                                            <td>
                                                @if ($order->status)
                                                    <button href="#" type="button"
                                                        class="btn btn-sm btn-success"><i
                                                            class="fa  fa-check"></i></button>
                                                @else
                                                    <a href="#" type="button" class="btn btn-sm btn-success"><i
                                                            class="fa fa-times"></i></a>
                                                @endif
                                            </td>
                                            <td class="actions">
                                                <a data-toggle="modal" data-target="#myModal"
                                                    href="{{ route('orders.show', $order) }}"
                                                    class="btn btn-warning btn-xs">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                    @lang('front.show')
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <td colspan="5">الإجمالى</td>
                                        <td>{{ currency($employee->saleOrders->sum('total'), 'EGP', 'EGP', $format = true) }}
                                        </td>
                                        <td>{{ $totalDiscount }}</td>
                                        <td>{{ currency($employee->saleOrders->sum('paid'), 'EGP', 'EGP', $format = true) }}
                                        </td>
                                        <td>{{ currency($employee->saleOrders->sum('due'), 'EGP', 'EGP', $format = true) }}
                                        </td>
                                        <td colspan="2"></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($employee->totalProduct))

                @if (count($employee->totalٌReturn))
                    @php
                        $returnproductArr = [];
                    @endphp
                    @foreach ($employee->mtotalٌReturn as $order)
                        @php
                            $returnproductArr[$order->product_id] = $order->sum;
                        @endphp
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">@lang('front.orderdetails')</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-striped dataTableTT">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.product')</th>
                                            <th>@lang('front.Total sales')</th>
                                            <th class="hide"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtt = 0;
                                            $ttt = 0;
                                        @endphp
                                        @foreach ($employee->totalProduct as $order)
                                            @php
                                                $subtt = isset($returnproductArr[$order->product_id]) ? $order->sum - $returnproductArr[$order->product_id] : $order->sum;
                                                $ttt += $subtt;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ optional($order->product)->name }} - ({{ $order->unit_id }})</td>
                                                <td>{{ $subtt }} {{ $order->unit_name }}</td>
                                                <td class="hide"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-danger">
                                            <td colspan="2">الإجمالى</td>
                                            <td>{{ $ttt }}</td>
                                            <td class="hide"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (count($employee->saleReturnsOrder))
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">@lang('front.Returns')</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="dataList" class="table table-breturned table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('front.date')</th>
                                            <th>@lang('front.client')</th>
                                            <th>@lang('front.total')</th>
                                            <th>@lang('front.salediscount')</th>
                                            <th>@lang('front.payment')</th>
                                            <th class="no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalRet = 0;
                                        @endphp
                                        @foreach ($employee->saleReturnsOrder as $return)
                                            @php
                                                $totalRet += $return->return_value;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $return->return_date }}</td>
                                                <td>{{ optional($return->client)->name }}</td>
                                                <td>
                                                    {{ currency($return->return_value, $return->currency, $return->currency, $format = true) }}
                                                </td>
                                                <td>{{ $return->sales_value }}</td>
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
                                        <tr class="bg-red">
                                            <td colspan="3">الإجمالى</td>
                                            <td class="text-bold">
                                                {{ currency($totalRet, currency()->config('default'), currency()->config('default'), true) }}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            @endif
        @endif

        @if ($employee->marketProduct && $employee->type == 'markter')
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('front.orderdetails')</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <table class="table table-bordered table-striped dataTableTT">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('front.product')</th>
                                        <th>@lang('front.commission')</th>
                                        <th>@lang('front.invoicenumber')</th>
                                        <th>@lang('front.date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->marketProduct as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->product->name }}</td>
                                            <td>{{ $order->sum }}</td>
                                            <td>{{ $order->order->invoice_number }}</td>
                                            <td>{{ $order->order->invoice_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if (count($expenses))
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-header">
                            <h3 class="box-title">@lang('front.expenses')</h3>
                        </div>
                        <div class="box-body">
                            @include('employees.empTrans', [
                                'title' => trans('front.expenses'),
                                'list' => $expenses,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (count($rewards))
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('front.Rewards and punishments')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-6">
                                @include('employees.empTrans', [
                                    'title' => trans('front.punishments'),
                                    'list' => $punishments,
                                ])
                            </div>
                            <div class="col-md-6">
                                @include('employees.empTrans', [
                                    'title' => trans('front.rewards'),
                                    'list' => $rewards,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

@stop
