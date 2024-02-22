
    <section class="content-header hideprint">
        <h1>
            @lang('front.orderdetails')
            <small>
                {{$order->invoice_number}}
            </small>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <a class="btn print-window pull-right" href="javascript:void(0)" onclick="PrintElem('{{route('orders.getPrint',$order->id)}}')" role="button">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </a>
                    <a class="btn print-window pull-right" href="{{route('order.create',['notpopup'=>'yes'])}}" role="button">
                        <i class="fa fa-backward" aria-hidden="true"></i> رجوع
                    </a>
                </h1>
            </div>
            <div class="col-md-12">
                <div id="printInvoice" class="box" style="border: none;">
                    <div class="box-body" style="max-width: 290mm!important;">
                        <div class="col-md-12 text-center">
                            <img style="width: 155px;" src="{{\Illuminate\Support\Facades\Storage::url($settings['logo'])}}">
                        </div>
                        <div  class="col-md-12 text-center">

                            <h3>
                                @if($order->invoice_type=='sales')
                                    Price List
                                @else
                                    @lang('front.purchase')
                                @endif

                            </h3>
                            @php
                                $dots='..........................';
                            @endphp
                            <table style="border: 0!important;" id="clientData" class="table">
                                <tr>
                                    <td><b>@lang('front.date') :</b> {{$order->invoice_date}}</td>
                                    <td><b>@lang('front.client') :</b> {{$order->client->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('front.telephone') :</b> {{$order->client->mobile??$dots}}</td>
                                    <td><b>@lang('front.telephone') :</b> {{$order->client->mobile2??$dots}}</td>
                                </tr>
                                <tr>
                                    <td><b>التسليم:توصيل/فرع:</b> {{ $dots }}</td>
                                    <td><b>الدفع فى: الإدارة/حوالة/فرع:</b> {{ $dots }}<td>
                                </tr>
                                <tr>
                                    <td><b>العنوان:</b> {{$order->client->address??$dots}}</td>
                                    <td><b>المحافظة:</b> {{optional($order->client->region)->name??$dots}}</td>

                                </tr>
                            </table>
                                @php
                                    $colspan = 4;
                                @endphp
                                <table style="max-width: 270mm!important;" class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>@lang('front.product')</td>
                                                @if($settings['show_category_in_invoice']==1)
                                                <td>@lang('front.parent')</td>
                                                @endif
                                                @if($settings['show_stores_in_invoices']==1)
                                                <td>@lang('front.store')</td>
                                                @endif
                                                <td>العدد</td>
                                                <td>سعر الوحدة</td>

                                                @if($settings['use_bounse']==1)
                                                <td>@lang('front.bounse')</td>
                                                @endif
                                                <td>@lang('front.total')</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $totalQty = 0;
                                            @endphp
                                            @foreach($order->details as $item)
                                                @php
                                                    $tqty = $item->pivot->qty - $item->pivot->return_qty;
                                                    $tval = $tqty * $item->pivot->price;
                                                    $totalQty += ($tqty);
                                                @endphp
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->name}}</td>
                                                    @if($settings['show_category_in_invoice']==1)
                                                        <td>{{optional($item->category)->name}}</td>
                                                    @endif
                                                    @if($settings['show_stores_in_invoices']==1)
                                                    <td>{{$item->pivot->store_name}}</td>
                                                    @endif
                                                    <td>{{$tqty??''}}</td>
                                                    <td>
                                                        {{(double)$item->pivot->price?currency($item->pivot->price,$order->currency, currency()->getUserCurrency(), $format = false):''}}
                                                    </td>
                                                    @if($settings['use_bounse']==1)
                                                    <td>{{$item->pivot->bounse}} {{$item->pivot->bounseUnitText}}</td>
                                                    @endif
                                                    <td>
                                                        {{$tval?currency($tval,$order->currency, currency()->getUserCurrency(), $format = true):''}}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr >
                                                    <td style="border: none!important;" colspan="{{$colspan}}">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p class="pull-left">استلمت الاصناف المذكوره عاليه بحالة جيدة وبالكميات المحدده</p>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="col-md-12">
                                                                <p class="pull-left">
                                                                    إجمالى الكميات : {{$totalQty}}
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
                                                        </div>
                                                    </td>
                                                    <td style="border: none!important;" colspan="2">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="no-line text-center">نولون الشحن :</td>
                                                                    <td class="no-line text-center">{{ $dots }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="no-line text-center">الإجمالى :</td>
                                                                    <td class="no-line text-center">{{$order->total?currency($order->total,$order->currency, currency()->getUserCurrency(), $format = true):''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="no-line text-center">تم دفع :</td>
                                                                    <td class="no-line text-center">{{$order->getOriginal('paid')?currency($order->getOriginal('paid'),$order->currency, currency()->getUserCurrency(), $format = true):$dots}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="no-line text-center">المبلغ المطلوب :</td>
                                                                    <td class="no-line text-center">{{ $dots }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    {{--</div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <style>
        #clientData.table tr>td{
            font-size: {{$settings['PrintSize']+2}}px!important;
            border:none!important;
            text-align: right!important;
            margin-bottom:0!important;
        }
        #clientData .table tr>td{
            text-align: right;
            border:none!important;
        }
        #printInvoice .table tr>td{
            text-align: center;
            border:1px solid #000;
        }
        #printInvoice .table thead tr>td{
            font-weight: bold;
        }
    </style>

