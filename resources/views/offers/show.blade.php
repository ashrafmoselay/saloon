<section class="content-header hideprint">
    <h1>
        @lang('front.orderdetails')
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
                    onclick="PrintElem('{{ route('offers.getPrint', $order->id) }}')" role="button">
                    <i class="fa fa-print" aria-hidden="true"></i>
                </a>
                <a class="btn print-window pull-right" href="{{ route('order.create', ['notpopup' => 'yes']) }}"
                    role="button">
                    <i class="fa fa-backward" aria-hidden="true"></i> رجوع
                </a>
            </h1>
        </div>
        <div class="col-md-12">
            <div id="printInvoice" class="box" style="border: none;">
                <div class="box-body" style="max-width: 290mm!important;">
                    <div class="col-md-12">
                        <div style="font-weight: bold;font-size: {{ $settings['PrintSize'] + 2 }}px!important;"
                            class="invoice-title">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="pull-left">
                                        <span style="font-size: 20px; ">{!! $settings['SiteName'] !!}</span><br />
                                        @if ($settings['taxNumber'])
                                            <span style="font-size: 16px; "> الرقم الضريبى:
                                                {{ $settings['taxNumber'] }}</span><br />
                                        @endif
                                        @if ($settings['Address'])
                                            <span style="font-size: 16px; ">{!! $settings['Address'] !!}</span><br />
                                        @endif
                                        @if ($settings['mobile'])
                                            <span style="font-size: 16px; ">{{ $settings['mobile'] }}</span><br />
                                        @endif
                                        تاريخ الطباعه : {{ date('Y-m-d') }}<br />
                                        مسئول الطباعه : {{ auth()->user()->name }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if ($settings['logo'])
                                        <div class="text-center">
                                            <img style="width: 155px;"
                                                src="{{ \Illuminate\Support\Facades\Storage::url($settings['logo']) }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h5 style="line-height: 25px;font-size: {{ $settings['PrintSize'] + 2 }}px!important;"
                                        class="pull-right">رقم العرض : {{ $order->id }}<br>
                                        @php
                                            $clientDetailes = optional($order->client);
                                        @endphp
                                        @lang('front.client') : {{ $clientDetailes->name }} <br />
                                        @if ($order->sale_id)
                                            @lang('front.sale') : {{ optional($order->saleMan)->name }}<br />
                                        @endif
                                        @if ($clientDetailes->mobile)
                                            @lang('front.telephone') : {{ $clientDetailes->mobile }} <br />
                                        @endif
                                        @if ($clientDetailes->address)
                                            @lang('front.address') : {{ $clientDetailes->address }} <br />
                                        @endif
                                        @if ($clientDetailes->taxnumber)
                                            الرقم الضريبي : {{ $clientDetailes->taxnumber }} <br />
                                        @endif

                                        @lang('front.date') : {{ $order->invoice_date }}

                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <h3
                            style="border-bottom: 1px solid grey;border-top: 1px solid grey;padding-bottom:10px;padding-top: 10px;">
                            عرض سعر # {{ $order->id }}
                        </h3>
                        @php
                            $colspan = 4;
                        @endphp
                        <table style="max-width: 270mm!important;" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td class="col-md-3">@lang('front.product')</td>
                                    @if ($settings['show_category_in_invoice'] == 1)
                                        <td>@lang('front.parent')</td>
                                    @endif
                                    @if ($settings['show_stores_in_invoices'] == 1)
                                        <td>@lang('front.store')</td>
                                    @endif
                                    <td>@lang('front.unit')</td>
                                    <td>@lang('front.quantity')</td>
                                    <td class="col-md-2">السعر</td>
                                    @if ($order->invoice_type == 'sales' && isset($settings['ShowCustomerPrice']) && $settings['ShowCustomerPrice'] == 1)
                                        @php
                                            $colspan = 6;
                                        @endphp
                                        <td>@lang('front.customer_price')</td>
                                    @endif

                                    <td class="col-md-2">@lang('front.total')</td>
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
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $item->full_name }}
                                            <br />
                                            <b>{{ $item->pivot->comment }}</b>
                                        </td>
                                        @if ($settings['show_category_in_invoice'] == 1)
                                            <td>{{ optional($item->category)->name }}</td>
                                        @endif
                                        @if ($settings['show_stores_in_invoices'] == 1)
                                            <td>{{ $item->pivot->store_name }}</td>
                                        @endif
                                        <td>{{ $item->pivot->unit_name }}</td>
                                        <td>
                                            <span style="font-weight: bold;"> {{ $tqty }} </span>
                                            @if ((int) $item->pivot->return_qty)
                                                <span
                                                    style="color: red;font-size: 10px;">({{ $item->pivot->return_qty }}
                                                    مرتجع) </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ currency($item->pivot->price, $order->currency, currency()->getUserCurrency(), $format = false) }}
                                        </td>
                                        @if ($order->invoice_type == 'sales' && isset($settings['ShowCustomerPrice']) && $settings['ShowCustomerPrice'] == 1)
                                            <td>{{ $item->pivot->customer_price }}</td>
                                        @endif
                                        <td>
                                            {{ currency($tval, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="border: none!important;" colspan="{{ $colspan }}">
                                        <div class="row">

                                            <div class="clearfix"></div>
                                            <div class="col-md-12">
                                                <p class="pull-left">
                                                    إجمالى الكميات : {{ $totalQty }}
                                                </p>
                                            </div>
                                            <div class="clearfix"></div>
                                            @if (isset($order->note) && !empty($order->note))
                                                <div class="clearfix"></div>
                                                <div style="direction: rtl" class="col-md-12">
                                                    {{ $order->note }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="border: none!important;" colspan="2">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td class="no-line text-center">الاجمالي قبل الضريبة :

                                                    </td>
                                                    <td>
                                                        {{ currency(round($order->total - $order->tax_value, 2), $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line text-center">
                                                        @lang('front.discount') :
                                                    </td>
                                                    <td class="no-line text-center">
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
                                                </tr>
                                                <tr>
                                                    <td class="no-line text-center">
                                                        قيمة الضريبة:
                                                    </td>

                                                    <td class="no-line text-center">
                                                        {{ currency(round($order->tax_value, 2), $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="no-line text-center">
                                                        إجمالى بعد الضريبة:
                                                    </td>

                                                    <td class="no-line text-center">
                                                        {{ currency($order->total, $order->currency, currency()->getUserCurrency(), $format = true) }}
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


</section>
<style>
    #printInvoice .table tr>td {
        text-align: center;
        border: 2px solid #000 !important;
    }

    #printInvoice .table thead tr>td {
        font-weight: bold;
    }
</style>
