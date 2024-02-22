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
                    onclick="PrintElem('{{ route('orders.getPrint', $order->id) }}')" role="button">
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
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        @if ($settings['logo'])
                                            <div class="pull-left">
                                                <img style="width: 155px;"
                                                    src="{{ \Illuminate\Support\Facades\Storage::url($settings['logo']) }}">
                                            </div>
                                        @endif
                                        <div class="pull-left">
                                            <h4>
                                                {!! $settings['SiteName'] !!}
                                            </h4>
                                            <div class="clearfix"></div>
                                            @if ($settings['Address'])
                                                <span style="font-size: 16px; ">{!! $settings['Address'] !!}</span>
                                                <div class="clearfix"></div>
                                            @endif
                                            @if ($settings['mobile'])
                                                <span style="line-height: 30px;">{{ $settings['mobile'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 style="line-height: 25px;font-size: {{ $settings['PrintSize'] + 2 }}px!important;"
                                            class="pull-right">@lang('front.invoicenumber') : {{ $order->invoice_number }}<br>
                                            @lang('front.client') : {{ $order->client->name }}
                                            @if ($order->sale_id)
                                                <br />
                                                @lang('front.sale') : {{ optional($order->saleMan)->name }}
                                            @endif
                                            @if ($order->client->mobile)
                                                <br />
                                                @lang('front.telephone') : {{ $order->client->mobile }}
                                            @endif <br />

                                            @lang('front.payment') :
                                            {{ in_array($order->payment_type, ['cash', 'delayed']) ? trans('app.' . $order->payment_type) : $order->payment_type }}
                                            <br />
                                            @lang('front.date') : {{ $order->invoice_date }}
                                            @if ($order->markter_id)
                                                <br />
                                                @lang('front.marketer') : {{ optional($order->market)->name }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <h3>
                            @if ($order->invoice_type == 'sales')
                                @lang('front.order') @if ($order->is_withdrawable == 1)
                                    | مسحوبات
                                @endif
                            @else
                                @lang('front.purchase')
                            @endif
                            # {{ $order->invoice_number }}
                        </h3>
                        @php
                            $colspan = 5;
                        @endphp
                        <table style="max-width: 270mm!important;" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>@lang('front.product')</td>
                                    @if ($settings['show_category_in_invoice'] == 1)
                                        <td>@lang('front.parent')</td>
                                    @endif
                                    @if ($settings['show_stores_in_invoices'] == 1)
                                        <td>@lang('front.store')</td>
                                    @endif
                                    <td>@lang('front.unit')</td>
                                    <td>@lang('front.quantity')</td>
                                    <td>البيع</td>
                                    @if ($order->invoice_type == 'sales' && isset($settings['ShowCustomerPrice']) && $settings['ShowCustomerPrice'] == 1)
                                        @php
                                            $colspan = 6;
                                        @endphp
                                        <td>@lang('front.customer_price')</td>
                                    @endif

                                    @if ($settings['use_bounse'] == 1)
                                        <td>@lang('front.bounse')</td>
                                    @endif
                                    <td>@lang('front.total')</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalQty = 0;
                                @endphp
                                @foreach ($order->details as $item)
                                    @php
                                        $tqty = $item->pivot->qty - $item->pivot->return_qty;
                                        $tval = $tqty * $item->pivot->price;
                                        $totalQty += $tqty;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        @if ($settings['show_category_in_invoice'] == 1)
                                            <td>{{ optional($item->category)->name }}</td>
                                        @endif
                                        @if ($settings['show_stores_in_invoices'] == 1)
                                            <td>{{ $item->pivot->store_name }}</td>
                                        @endif
                                        <td>{{ $item->pivot->unit_name }}</td>
                                        <td>{{ $tqty }}</td>
                                        <td>
                                            {{ currency($item->pivot->price, $order->currency, currency()->getUserCurrency(), $format = false) }}
                                        </td>
                                        @if ($order->invoice_type == 'sales' && isset($settings['ShowCustomerPrice']) && $settings['ShowCustomerPrice'] == 1)
                                            <td>{{ $item->pivot->customer_price }}</td>
                                        @endif
                                        @if ($settings['use_bounse'] == 1)
                                            <td>{{ $item->pivot->bounse }} {{ $item->pivot->bounseUnitText }}</td>
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
                                            <div class="col-md-12">
                                                <p class="pull-left">استلمت الاصناف المذكوره عاليه بحالة جيدة وبالكميات
                                                    المحدده</p>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-12">
                                                <p class="pull-left">
                                                    إجمالى الكميات : {{ $totalQty }}
                                                </p>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-12">
                                                <p class="pull-left">
                                                    توقيع المندوب :
                                                </p>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-12">
                                                <p class="pull-left">
                                                    توقيع المستلم :
                                                </p>
                                            </div>

                                            <div class="clearfix"></div>
                                            <div style="direction: rtl" class="col-md-12">
                                                {!! $settings['InvoiceNotes'] !!}
                                            </div>
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
                                                    <td class="no-line text-center">@lang('front.total') :</td>
                                                    <td class="no-line text-center">
                                                        {{ currency($order->total, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line text-center">@lang('front.tax') :
                                                        {{ $order->tax }}%</td>
                                                    <td class="no-line text-center">@lang('front.discount') :

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
                                                    <td class="no-line text-center">@lang('front.paid') :
                                                        {{ currency($order->getOriginal('paid'), $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                    </td>
                                                    <td class="no-line text-center">@lang('front.due') :
                                                        {{ $order->due }} </td>
                                                    {{-- <td class="no-line text-center">@lang('front.before') : {{currency($order->client->total_due-$order->due,$order->currency, currency()->getUserCurrency(), $format = true)}} </td> --}}
                                                </tr>
                                                @if ($order->id == $order->client->latestOrder->id)
                                                    <tr>
                                                        <td class="no-line text-center">@lang('front.before') : </td>
                                                        <td class="no-line text-center">
                                                            {{ currency($order->client->total_due - $order->due, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line text-center text-bold">@lang('front.balance') :
                                                        </td>
                                                        <td class="no-line text-center text-bold">
                                                            {{ $order->client->balnce_text }} </td>
                                                    </tr>
                                                @endif
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
