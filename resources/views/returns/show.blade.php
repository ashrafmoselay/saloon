
<section class="content-header">
    <h1>
       @lang('front.ordreturn')
        <small>
            {{$return->id}}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <a class="btn print-window pull-right" href="javascript:void(0)" onclick="PrintElem('{{route('returns.getPrint',$return->id)}}')" role="button">
                    <i class="fa fa-print" aria-hidden="true"></i>
                </a>
            </h1>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="invoice-title">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        @if($settings['logo'])
                                            <div class="pull-left">
                                                <img style="width: 155px;" src="{{\Illuminate\Support\Facades\Storage::url($settings['logo'])}}">
                                            </div>
                                        @endif
                                        <div class="pull-left">
                                            <h4>
                                                {!! $settings['SiteName'] !!}
                                            </h4>
                                            <div class="clearfix"></div>
                                            @if($settings['Address'])
                                                <span style="font-size: 16px; ">{!!$settings['Address']!!}</span>
                                                <div class="clearfix"></div>
                                            @endif
                                            @if($settings['mobile'])
                                                <span style="line-height: 30px;">{{$settings['mobile']}}</span>
                                            @endif
                                            <br/>
                                            <p style=" background-color: #ccc; padding: 5px;">إشعار دائن للفاتورة الضريبية</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 style="line-height: 25px;" class="pull-right">@lang('front.invoicenumber') : {{$return->id}}<br>
                                            @lang('front.client') : {{$return->client->name}}<br>



                                            @lang('front.payment') : {{$return->is_cash?trans('front.cash'):trans('front.from previous balance')}} <br>
                                            @lang('front.date') : {{$return->return_date}}</br>
                                            @if($return->order_id)
                                                <p style=" background-color: #ccc; padding: 5px; ">@lang('front.returndfrom'): {{optional($return->order)->invoice_number}}</p>
                                            @endif

                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            {{--<div class="panel-heading">
                                <h3 class="panel-title">اﻷصناف</h3>
                            </div>--}}
                            <div class="panel-body">
                                <div class="table-responsive">

                                    <h3 class="text-center">
                                        @if($return->return_type=='sales')
                                            @lang('front.ordreturn')
                                        @else
                                            @lang('front.purreturn')
                                        @endif
                                    </h3>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>@lang('front.product')</td>
                                            @if($settings['show_category_in_invoice'])
                                                <td>@lang('front.parent')</td>
                                            @endif
                                            @if($settings['show_stores_in_invoices']==1)
                                                <td>@lang('front.parent')</td>
                                            @endif
                                            <td>@lang('front.quantity')</td>
                                            <td>@lang('front.unit')</td>
                                            <td>@lang('front.price')</td>
                                            <td>@lang('front.total')</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total = 0;
                                            $totalQty = 0;
                                            $colspan = 4;
                                        @endphp
                                        @foreach($return->details as $item)

                                            @php
                                                $subtotal = $item->pivot->qty*$item->pivot->price;
                                                $total += $subtotal;
                                                $totalQty += ($item->pivot->qty);
                                            @endphp
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->name}}</td>
                                                @if($settings['show_category_in_invoice'])
                                                    <td>{{optional($item->category)->name}}</td>
                                                    @php
                                                        $colspan = 5;
                                                    @endphp
                                                @endif
                                                @if($settings['show_stores_in_invoices']==1)
                                                    <td>{{$item->pivot->store_name}}</td>
                                                    @php
                                                        $colspan = 6;
                                                    @endphp
                                                @endif
                                                <td>{{$item->pivot->qty}}</td>
                                                <td>{{$item->pivot->unit_name}}</td>
                                                <td>{{$item->pivot->price}}</td>
                                                <td>{{$subtotal}}</td>
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
                                                            <td class="no-line text-center">@lang('front.tax') :</td>
                                                            <td class="no-line text-center">{{$return->tax}}%</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line text-center">@lang('front.total') :</td>
                                                            <td class="no-line text-center">{{currency($return->total,$return->currency, currency()->getUserCurrency(), $format = true)}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="no-line text-center">@lang('front.discount')</td>
                                                            <td class="no-line text-center">

                                                                @php
                                                                    $discount = 0;
                                                                    $dist = $return->discount;
                                                                    if($return->discount){
                                                                        if($return->discount_type==2){
                                                                            $discount=$return->total*($return->discount/100);
                                                                            $dist=$discount;
                                                                            //$dist = "%".$return->discount. " ( $discount )";
                                                                        }
                                                                    }
                                                                @endphp
                                                                {{currency($dist,$return->currency, currency()->getUserCurrency(), $format = true)}}

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td class="no-line text-center text-bold">@lang('front.balance') :</td>
                                                            <td class="no-line text-center text-bold">{{$return->client->balnce_text}}  </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2" style="border: none!important;">
                                                                @php
                                                                $check = true;
                                                                try{
                                                                    $datahtml = $settings['SiteName']."\n".
                                                                    " الرقم الضريبى: ".$settings['taxNumber']."\n".
                                                                    "التاريخ : ".$return->created_at->format('Y-m-d')."\n".
                                                                    "رقم الفاتورة: ".$return->id."\n".
                                                                    "إجمالى: ".$return->total."\n".
                                                                    "قيمة الضريبة: ". $return->tax_value;
                                                                    $Qcode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                                                                    ->encoding('UTF-8')
                                                                    ->size(200)
                                                                    ->generate($datahtml));
                                                                }catch (\Exception $e){
                                                                    //dd($e->getMessage());
                                                                    $check = false;
                                                                }
                                                            @endphp
                                                            @if($check)
                                                                <div style="margin-bottom: 5px;">
                                                                    <img src="data:image/png;base64,  {!! $Qcode !!}">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<style>
    .table tr>td{
        text-align: center;
    }
    .table thead tr>td{
        font-weight: bold;
    }
</style>
