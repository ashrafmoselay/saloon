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
                                            <h5 style="line-height: 25px;" class="pull-left">رقم الفاتورة :
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
                                                <br />
                                                المنطقة : {{ optional($order->client->region)->name ?? '' }}

                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            @if ($settings['logo'])
                                                <div class="pull-right">
                                                    <img style="width: 250px;"
                                                        src="{{ \Illuminate\Support\Facades\Storage::url($settings['logo']) }}">
                                                </div>
                                            @endif
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
                                        <td>الصنف</td>
                                        <td>سعر الجمهور</td>
                                        <td colspan="2">الخصم</td>
                                        <td>السعر بعد الخصم</td>
                                        <td>الكمية</td>
                                        <td>البونص</td>
                                        <td>الإجمالي</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalQty = 0;
                                        $finalPrice = 0;
                                    @endphp
                                    @foreach ($order->details as $item)
                                        @php
                                            $tqty = $item->pivot->qty;
                                            $itemPrice = $item->pivot->price;
                                            if ($item->pivot->discount1) {
                                                $itemPrice -= ($itemPrice * $item->pivot->discount1) / 100;
                                            }
                                            if ($item->pivot->discount2) {
                                                $itemPrice -= ($itemPrice * $item->pivot->discount2) / 100;
                                            }
                                            $finalPrice = $tqty * $itemPrice;
                                            $totalQty += $tqty;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                {{ currency($item->pivot->price, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                            </td>
                                            <td>{{ $item->pivot->discount1 }}</td>
                                            <td>{{ $item->pivot->discount2 }}</td>
                                            <td>
                                                {{ currency($itemPrice, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                            </td>
                                            <td>{{ $item->pivot->qty }}</td>
                                            <td>{{ $item->pivot->bounse }}</td>

                                            <td>
                                                {{ currency($finalPrice, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <br />
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
@push('css')
    <style>
        .disStyle {
            float: right !important;
            width: 43% !important;
            margin: 2px;
        }
    </style>
    <style>
        .table tr>td {
            text-align: center;
            vertical-align: middle !important;
        }

        .table thead tr>td {
            font-weight: bold;
            vertical-align: middle;
        }

        .table {
            border: 1px solid black;
            color: #000 !important;
        }

        .table tr,
        .table tr td,
        .table tr>td,
        thead tr>td,
        td {
            border: 1px solid black !important;
            vertical-align: middle;
        }
    </style>
@endpush
