<table class="table">
    <tbody>
    @php
        $index = 1;
        $printed = 1;
        $count = $copies/4;
        if($from>1){
            $count = ceil(($copies+$from)/4);
        }
    @endphp
    @for($k=0;$k<$count;$k++)
        <tr>
            @for($i=0;$i<4;$i++)

                <td class="genCode">
                    @if($index>=$from && $printed <= $copies)
                        <h6>{{$product->name}}</h6>
                        {!!'<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->code, $generator::TYPE_CODE_39)) . '">'!!}
                        <h6 class="stretch">
                            {{$product->code}}
                        </h6>
                        <h6> السعر : <span>
                                {{currency((double)$product->productUnit()->first()->pivot->sale_price,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                            </span></h6>
                        @php
                            $printed++;
                        @endphp
                    @endif
                </td>

                @php
                    $index++;
                @endphp
            @endfor
        </tr>
    @endfor
    </tbody>
</table>

@push('css')
    <style>
        .table {
            width: 795px;
            margin: 0 auto;
            max-width: 100%;
            margin-bottom: 0px!important;
            padding: 0!important;
        }
        .genCode img{
            width: 3.25cm;
            height: 18px;
        }
        /*.genCode h6 span{
            font-size: 12px;
        }*/
        .genCode h6{
            font-size: 11px;
            text-align: center;
            white-space:nowrap;
            overflow: hidden;
            font-weight: bold;
            padding-bottom: 5px;
            padding-left: 5px!important;
            margin: 0 auto!important;


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
            width: 5cm!important;
            height: 2.5cm!important;
            max-width: 5cm!important;
            max-height: 2.5cm!important;
            min-width: 5cm!important;
            min-height: 2.5cm!important;
            text-align: center;
            vertical-align: middle!important;
        }
        @media print {
            .box-body {
                padding: 0px!important;
            }
            .content {
                min-height: 0px;
                padding: 0px!important;
                margin: 0px!important;
            }

            .box {
                border: none;
                margin: 0px!important;
            }
            table{
                border-top:0;

            }

            table>tbody>tr>td,table, caption, tbody, tfoot, thead, tr, th, td {
                /*border: none!important;*/
                vertical-align: middle!important;
                margin: 0;
                padding: 0;
                border: 0;
                vertical-align: baseline;
            }
            table{
                /*width: 50%;*/
                /*margin: 5px;*/
                border-collapse: collapse;
            }
            td, th {
                padding-bottom: 8px !important;
                padding-right: 10px !important;
                padding-left: 10px !important;
                padding-top: 15px !important;
            }
            @page {
                margin-top: .9cm;
                margin-bottom: .5cm;
                margin-left: .6cm;
                margin-right: .4cm;
            }
            /*@page:right{
                @bottom-left {
                    margin: 10pt 0 30pt 0;
                    border-top: .25pt solid #666;
                    content: "Our Cats";
                    font-size: 9pt;
                    color: #333;
                }

                @bottom-right {
                    margin: 10pt 0 30pt 0;
                    border-top: .25pt solid #666;
                    content: counter(page);
                    font-size: 9pt;
                }

                @top-right {
                    content:  string(doctitle);
                    margin: 30pt 0 10pt 0;
                    font-size: 9pt;
                    color: #333;
                }
            }*/
            body {margin: 0;}

        }
    </style>
@endpush
