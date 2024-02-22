
@for($k=0;$k<$copies;$k++)
    <div class="genCode">
    <h6>{{$product->name}}</h6>
    {!!'<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->code, $generator::TYPE_CODE_39)) . '">'!!}
    <h6 class="stretch">
        {{$product->code}}
    </h6>
    <h6> السعر : <span>
            {{currency((double)$product->productUnit()->first()->pivot->sale_price,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
    </span></h6>
    </div>
@endfor
    <style>

        /*.genCode h6 span{
            font-size: 12px;
        }*/
        .genCode img{
            width: 38mm;
            height: 10mm;
        }
        .genCode h6{
            font-size: 9px;
            white-space:nowrap;
            font-weight: bold;
            width: 100%;
            text-align: center;
            margin: 0!important;
            padding: 5px!important;
        }
        .stretch {
            -webkit-transform:scale(2,1); /* Safari and Chrome */
            -moz-transform:scale(2,1); /* Firefox */
            -ms-transform:scale(2,1); /* IE 9 */
            -o-transform:scale(2,1); /* Opera */
            transform:scale(2,1); /* W3C */
            font-size: 9px!important;
        }
        .genCode{
            border: none;
            width: 38mm!important;
            height: 25mm!important;
            vertical-align: middle!important;
            position: absolute;
            left: 0;
            top: 0;
        }

        @media print {
            html, body {
                width: 100%;
                height: 100%;
                max-width: 100%;
                max-height: 97%;
                margin: 0!important;
                padding: 0!important;
                position: relative;
            }
            @page{
                size: 38mm 25mm!important;;
                margin: 0!important;;
                padding: 0!important;
            }
        }
    </style>
