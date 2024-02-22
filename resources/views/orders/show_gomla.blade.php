<section class="content-header">
    <h1>
        تفاصيل الفاتورة
        <small>
            {{ $order->invoice_number }}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <a class="btn print-window pull-right" href="javascript:void(0)"
                    onclick="PrintElem('{{ route('orders.getPrint', $order->id) }}')" role="button">
                    <i class="fa fa-print" aria-hidden="true"></i>
                </a>
            </h1>
        </div>
        <div class="col-md-12">
            <div id="printInvoice" class="box" style="border: none;">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-title">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="pull-left">
                                                <h4>
                                                    {!! $settings['SiteName'] !!}
                                                </h4>

                                                <div class="clearfix"></div>
                                                @if ($settings['Address'])
                                                    <span>{!! $settings['Address'] !!}</span><br>
                                                @endif
                                                @if ($settings['mobile'])
                                                    <span style="line-height: 30px;">{{ $settings['mobile'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 style="line-height: 25px;" class="pull-right">رقم الفاتورة :
                                                {{ $order->invoice_number }}<br>
                                                اسم العميل : {{ $order->client->name }}
                                                @if ($order->sale_id)
                                                    <br />
                                                    اسم المندوب : {{ optional($order->saleMan)->name }}
                                                @endif
                                                @if ($order->client->mobile)
                                                    <br />
                                                    رقم الموبيل : {{ $order->client->mobile }}
                                                @endif <br />

                                                طريقة الدفع :
                                                {{ in_array($order->payment_type, ['cash', 'delayed']) ? trans('app.' . $order->payment_type) : $order->payment_type }}
                                                <br />
                                                التاريخ : {{ $order->invoice_date }}
                                                @if ($order->markter_id)
                                                    <br />
                                                    اسم المسوق : {{ optional($order->market)->name }}
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3 class="text-center">
                                @if ($order->invoice_type == 'sales')
                                    فاتورة مبيعات
                                @else
                                    فاتورة مشتريات
                                @endif
                            </h3>
                            {{-- <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">اﻷصناف</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive"> --}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>الكمية</td>
                                        <td>إسم الصنف</td>
                                        @if ($settings['show_category_in_invoice'] == 1)
                                            <td>الفئة</td>
                                        @endif
                                        @if ($settings['show_stores_in_invoices'] == 1)
                                            <td>المخزن</td>
                                        @endif
                                        <td>الوحدة</td>
                                        <td>السعر</td>
                                        <td>الإجمالى</td>
                                        <td>م</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalQty = 0;
                                    @endphp
                                    @foreach ($order->details as $item)
                                        @php
                                            $tqty = $item->pivot->qty;
                                            $tval = $tqty * $item->pivot->price;
                                            $totalQty += $tqty;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->pivot->qty }}</td>
                                            <td>{{ $item->name }}</td>
                                            @if ($settings['show_category_in_invoice'] == 1)
                                                <td>{{ optional($item->category)->name }}</td>
                                            @endif
                                            @if ($settings['show_stores_in_invoices'] == 1)
                                                <td>{{ $item->pivot->store_name }}</td>
                                            @endif
                                            <td>{{ $item->pivot->unit_name }}</td>
                                            <td>
                                                {{ currency($item->pivot->price, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                            </td>
                                            <td>
                                                {{ currency($tval, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        @if ($order->tax != 0)
                                                            <td colspan="" class="no-line text-center">الضريبة
                                                                المضافة : {{ $order->tax }}%</td>
                                                        @endif
                                                        <td class="no-line text-center">إجمالى الفاتورة :
                                                            {{ currency($order->getOriginal('total'), $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>

                                                        @if ((float) $order->discount)
                                                            <td class="no-line text-center">قيمة الخصم :

                                                                @php
                                                                    $discount = 0;
                                                                    $dist = $order->discount;
                                                                    if ($order->discount) {
                                                                        if ($order->discount_type == 2) {
                                                                            $discount = $order->total * ($order->discount / 100);
                                                                            $dist = $discount;
                                                                            //$dist = "%".$order->discount. " ( $discount )";
                                                                        }
                                                                    }
                                                                @endphp
                                                                {{ currency($dist, $order->currency, currency()->getUserCurrency(), $format = true) }}

                                                            </td>
                                                        @endif
                                                        <td class="no-line text-center">المبلغ المدفوع :
                                                            {{ currency($order->getOriginal('paid'), $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>
                                                        <td class="no-line text-center">المبلغ المتبقى :
                                                            {{ currency($order->getOriginal('due'), $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>
                                                        <td class="no-line text-center">رصيد سابق :
                                                            {{ currency($order->client->total_due - $order->due, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>
                                                        <td class="no-line text-center">رصيد حالى :
                                                            {{ currency($order->client->total_due, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<style>
    .table tr>td {
        text-align: center;
    }

    .table thead tr>td {
        font-weight: bold;
    }

    .table {
        border: 1px solid black;
    }

    .table tr,
    .table tr td,
    .table tr>td,
    thead tr>td,
    td {
        border: 1px solid black !important;
    }
</style>
