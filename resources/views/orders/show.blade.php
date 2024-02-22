@if ($settings['industrial'] == 3 && $order->invoice_type == 'sales')
    @include('orders.show_pharma')
@else
    <section class="content-header hideprint">
        <h1>
            @lang('front.orderdetails')
            <small>
                {{ $order->invoice_number }}
            </small>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                    class="fa fa-times"></i></button>
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
                                            class="pull-right">@lang('front.invoicenumber') : {{ $order->invoice_number }}<br>
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
                                            @lang('front.payment') :
                                            {{ in_array($order->payment_type, ['cash', 'delayed']) ? trans('app.' . $order->payment_type) : $order->payment_type }}
                                            <br />
                                            @lang('front.date') : {{ $order->order_date }}
                                            @if ($order->markter_id)
                                                <br />
                                                @lang('front.marketer') : {{ optional($order->market)->name }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3
                                style="border-bottom: 1px solid grey;border-top: 1px solid grey;padding-bottom:10px;padding-top: 10px;">
                                فاتورة ضريبية</h3>
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
                                $colspan = 4;
                            @endphp
                            <table style="max-width: 270mm!important;" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td class="col-md-4">@lang('front.product')</td>
                                        @if ($settings['show_category_in_invoice'] == 1)
                                            <td>@lang('front.parent')</td>
                                            @php
                                                $colspan++;
                                            @endphp
                                        @endif
                                        @if ($settings['show_stores_in_invoices'] == 1)
                                            <td>@lang('front.store')</td>
                                            @php
                                                $colspan++;
                                            @endphp
                                        @endif
                                        <td>@lang('front.unit')</td>
                                        <td>@lang('front.quantity')</td>
                                        <td>البيع</td>
                                        @if ($order->invoice_type == 'sales' && isset($settings['ShowCustomerPrice']) && $settings['ShowCustomerPrice'] == 1)
                                            @php
                                                $colspan++;
                                            @endphp
                                            <td>@lang('front.customer_price')</td>
                                        @endif

                                        @if ($settings['use_bounse'] == 1)
                                            <td>@lang('front.bounse')</td>
                                            @php
                                                $colspan++;
                                            @endphp
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
                                                <img style="width: 20px;" class="stateIcon"
                                                    src="{{ $item->pivot->status ? asset('icons/yes.png') : asset('icons/no.png') }}" />
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
                                                    <p class="pull-left">استلمت الاصناف المذكوره عاليه بحالة جيدة
                                                        وبالكميات
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
                                                        <td class="no-line text-center">الاجمالي قبل الضريبة :
                                                            {{ currency($order->total_without_tax, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                        </td>
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
                                                        <td class="no-line text-center">قيمة الضريبة :
                                                            {{ round($order->tax_value, 2) }}</td>

                                                        <td class="no-line text-center">الإجمالي :
                                                            {{ currency($order->total, $order->currency, currency()->getUserCurrency(), $format = true) }}
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
                                                    @if (false && $order->id == $order->client->latestOrder->id)
                                                        <tr>
                                                            <td class="no-line text-center">@lang('front.before') : </td>
                                                            <td class="no-line text-center">
                                                                {{ currency($order->client->total_due - $order->due, $order->currency, currency()->getUserCurrency(), $format = true) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line text-center text-bold">@lang('front.balance')
                                                                :
                                                            </td>
                                                            <td class="no-line text-center text-bold">
                                                                {{ $order->client->balnce_text }} </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2" style="border: none!important;">
                                                            @php
                                                                $check = true;
                                                                try {
                                                                    $Qcode = $order->generatQrcode($settings['SiteName'], $settings['taxNumber'], $order->order_date, $order->total, $order->tax_value);
                                                                } catch (\Exception $e) {
                                                                    //dd($e->getMessage());
                                                                    $check = false;
                                                                }
                                                            @endphp
                                                            @if ($check && $Qcode)
                                                                <div style="margin-bottom: 5px;">
                                                                    <img src="{{ $Qcode }}">
                                                                </div>
                                                            @endif
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
@endif
<style>
    #printInvoice .table tr>td {
        text-align: center;
        border: 2px solid #000 !important;
    }

    #printInvoice .table thead tr>td {
        font-weight: bold;
    }
</style>
