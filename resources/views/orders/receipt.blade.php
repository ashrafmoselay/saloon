<style type="text/css">
    * {
        font-size: {{ $settings['PrintSize'] }}px !important;
        font-family: 'Times New Roman';
        font-weight: bold;
    }

    .centered {
        text-align: center;
        align-content: center;
    }


    img {
        max-width: inherit;
        width: inherit;
    }

    @media print {

        .hidden-print,
        .hidden-print * {
            display: none !important;
        }

        .ticket,
        table {
            max-width: 10.7cm;
            width: 10.7cm;
        }
    }

    .centered {
        text-align: center;
        align-content: center;
    }

    @media print {

        .ticket,
        table {
            max-width: 10.7cm;
            width: 10cm;
            text-align: center;
            font-weight: bold;
            margin: 10px;
        }

        .table {
            font-size: {{ $settings['PrintSize'] ?? 12 }}px !important;
        }

        td,
        th,
        tr,
        table {
            border: 1px solid black !important;
            border-collapse: collapse;
        }

        .table {
            border: 1px solid #020202 !important;
        }

        .table td,
        .table th {
            border: 1px solid #020202 !important;
        }

        html,
        body {
            margin-top: 0.1cm;
        }

        @page {
            size: auto;
            margin-left: 0.1cm;
            margin-right: 0.1px;
            margin-top: 0.1cm;
        }
    }
</style>

<a class="btn print-window pull-right" href="{{ route('pos') }}" role="button">
    <i class="fa fa-backward" aria-hidden="true"></i> رجوع
</a>
<div class="ticket">
    @if ($settings['logo'])
        <div class="pull-right">
            <img style="width: 110px" alt="Logo"
                src="{{ \Illuminate\Support\Facades\Storage::url($settings['logo']) }}
        ">
        </div>
    @endif
    <div style="margin-bottom: 15px;" class="pull-left">
        {!! $settings['SiteName'] !!}
        <br>
        @if ($settings['Address'])
            {!! $settings['Address'] !!}
        @endif
        <br>
        @if ($settings['mobile'])
            {{ $settings['mobile'] }} <br>
        @endif

        تاريخ الطباعه : {{ date('Y-m-d') }}<br />

        مسئول الطباعه : {{ auth()->user()->name }}

    </div>
    <table style="margin-top: 10px;" class="table table-bordered">
        <tr>
            <td style="font-weight: bold;font-size:18px!important;" colspan="2">فاتورة ضريبية مبسطة</td>
        </tr>
        <tr>
            <td>الفاتورة #</td>
            <td>{{ $order->invoice_number }}</td>
        </tr>
        <tr>
            <td>الدفع</td>
            <td>{{ $order->payment_type == 'delayed' ? 'أجل' : 'كاش' }}</td>
        </tr>
        <tr>
            <td>التاريخ</td>
            <td>{{ $order->invoice_date }}</td>
        </tr>
        <tr>
            <td>الكاشير</td>
            <td>{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <td>م. المبيعات</td>
            <td>{{ optional($order->saleMan)->name }}</td>
        </tr>
        <tr>
            <td>العميل</td>
            <td>{{ $order->client->name }}</td>
        </tr>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="quantity">الكمية</th>
                <th class="description">الوصف</th>
                <th class="price">السعر</th>
                <th class="price">إجمالى</th>
            </tr>
        </thead>
        <tbody>
            @php
                $numqty = 0;
                $sumprice = 0;
            @endphp
            @foreach ($order->details as $item)
                <tr>
                    @php
                        $numqty += $item->pivot->qty;
                        $sumprice += $item->pivot->total;
                    @endphp
                    <td class="quantity">{{ $item->pivot->qty }}</td>
                    <td class="description">
                        {{ $item->name }}<br />
                        {{ $item->pivot->comment }}
                    </td>
                    <td class="price">
                        {{ currency($item->pivot->price, $order->currency, currency()->getUserCurrency(), $format = true) }}
                    </td>
                    <td>
                        {{ currency($item->pivot->total, $order->currency, currency()->getUserCurrency(), $format = true) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>عدد القطع</td>
                <td>{{ $numqty }}</td>
                <td>الإجمالى</td>
                <td>
                    {{ currency($sumprice, $order->currency, currency()->getUserCurrency(), $format = true) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table">
                        <tr>
                            <td>الاجمالي قبل الضريبة</td>
                            <td>{{ currency($order->total - $order->tax_value, $order->currency, currency()->getUserCurrency(), $format = true) }}
                            </td>
                        </tr>
                        <tr>
                            <td>الضريبة</td>
                            <td>{{ $order->tax }}%</td>
                        </tr>
                        <tr>
                            <td>الخصم</td>
                            <td>
                                @php
                                    $discount = 0;
                                    $dist = $order->discount ?: 0;
                                    if ($order->discount) {
                                        if ($order->discount_type == 2) {
                                            $discount = $order->total * ($order->discount / 100);
                                            $dist = $discount;
                                            //$dist = "%".$order->discount. " ( $discount )";
                                        }
                                    }
                                    $totalafterDisc = $order->total - $dist;
                                @endphp
                                {{ currency($dist, $order->currency, currency()->getUserCurrency(), $format = true) }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table class="table">
                        <tr>
                            <td>المجموع</td>
                        </tr>
                        <tr>
                            <td>
                                {{ currency($totalafterDisc, $order->currency, currency()->getUserCurrency(), $format = true) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">إجمالى المستحقات</td>
            </tr>
            <tr>
                <td colspan="4">
                    {{ currency($totalafterDisc, $order->currency, currency()->getUserCurrency(), $format = true) }}
                </td>
            </tr>
            @if ($order->client->total_due || $order->due)
                <tr>
                    <td colspan="4">
                        <table class="table">
                            <tr>
                                <td colspan="2">كشف حساب مختصر</td>
                            </tr>
                            <tr>
                                <td>المديونية السابقة</td>
                                <td>
                                    @php
                                        $total_due = $order->client->total_due;
                                    @endphp
                                    @if ($total_due)
                                        {{ currency($total_due - $order->due, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>الرصيد</td>
                                <td>{{ currency($total_due, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                </td>
                            </tr>
            @endif
    </table>
    </td>
    </tr>
    <tr>
        <td colspan="4">
            <p>
                {!! $settings['InvoiceNotes'] !!}
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            @php
                $check = true;
                try {
                    $Qcode = $order->generatQrcode($settings['SiteName'], $settings['taxNumber'], $order->order_date, $order->total, $order->tax_value);
                } catch (\Exception $e) {
                    //dd($e->getMessage());
                    $check = false;
                }
            @endphp
            @if ($check)
                <div style="margin-bottom: 5px;">
                    <img src="{{ $Qcode }}">
                </div>
            @endif
        </td>
    </tr>
    </tfoot>
    </table>
</div>
