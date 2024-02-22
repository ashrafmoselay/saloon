<html >
<head>
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE-rtl.min.css">
    <style>
        .genCode img{
            width: {{$width-0.5}}cm;
            height: {{$height-1.7}}cm;
            margin-bottom: 2px;
        }
        .genCode h6{
            font-size: 8px!important;
            white-space:nowrap;
            font-weight: bold;
            width: 100%;
            margin: 0!important;
            padding: 0px!important;
            padding-bottom: 5px!important;
        }
        .genCode .stretch {
            -webkit-transform:scale(2,1);
            -moz-transform:scale(2,1);
            -ms-transform:scale(2,1);
            -o-transform:scale(2,1);
            transform:scale(2,1);
            font-size: 7px!important;
        }
        .genCode{
            width: {{$width}}cm!important;
            height: {{$height}}cm!important;
            vertical-align: middle!important;
            text-align: center!important;
            line-height: 14px;
            overflow: hidden;
        }
        .genCode .title{
            font-size: 8px!important;
            vertical-align: middle!important;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: {{$width}}cm;
            direction: rtl;
            float:right;

        }
        .title_type,.stretch{
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            direction: rtl;
        }
        .genCode .country{
            float: left;
            width: 55px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            direction: rtl;
        }

        @media print {
            html, body {
                margin-left: 0cm;
                margin-right: 0px;
                margin-top: 0cm;
                margin-bottom: 0px;
                padding: 0px!important;
            }
            @page{
                size: {{$width}}cm {{$height}}cm!important;
                margin-left: {{$margin_left}}cm;
                margin-right: .3cm;
                margin-top: {{$margin_top}}cm;
                margin-bottom: .3px;
                padding: 0cm!important;
            vertical-align: middle!important;
            text-align: center!important;

            }
        }
        .genCode h6.bsmall{
            line-height: 9px!important;
            margin: 0px!important;
            padding: 0px!important;
            padding-bottom: 2.25px!important;
        }
        </style>
</head>
<body>

@if($width==3.9)
<div class="genCode">
@for($i=0;$i<2;$i++)
    <h6 style="font-size: 7.5px;" class="title_type bsmall">{{$product->name}}</h6>
    {!!'<img style="width: 3.25cm;height: 0.62cm" src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->code, $barcodetype)) . '">'!!}
    <h6 style="font-size: 8px;" class="bsmall"> السعر : <span>
            {{currency((double)$product->productUnit()->first()->pivot->sale_price,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
    </span></h6>
@endfor
</div>
@else
<div class="genCode">
    <div class="pull-right" style="margin-bottom: 3px;">
        <span class="title">{!! $settings['SiteName'] !!}</span>
        <!-- <span class="country">مصرى<span> -->
    </div>
    {!!'<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->code, $barcodetype)) . '">'!!}
    <h6 class="title_type">{{$product->name}}</h6>
    <h6 class="stretch">
        {{$product->code}}
    </h6>
    <h6> السعر : <span>
            {{currency((double)$product->productUnit()->first()->pivot->sale_price,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
    </span></h6>
</div>
@endif
</body>
</html>
