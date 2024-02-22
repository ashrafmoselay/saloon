<html dir="rtl">
<head>
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap-rtl.min.css">
    <style>
        @media print {

            .printHeader{
                display: block!important;
            }
            a[href]:after {
                content: none !important;display: none !important;
            }
            .main-footer,.dt-buttons,.dataTables_filter{
                display: none ;display: none !important;
            }

            #footer{visibility: visible;display: none !important;}
            a{
                visibility:hidden;display: none !important;
            }
            .table {
                border: 1px solid black !important;
            }
            .table td,.table thead tr th {
                border: 1px solid black !important;
            }
            @media print {
                .printHeader{
                    display: block!important;
                }
                table  {
                    font-size: {{$settings['PrintSize']}}px !important;
                }
                @page { margin: .1cm; }
                body { margin: .1cm;}
                .panel-default{
                    border: none;
                }
                .hideprint{
                    visibility:hidden;
                    margin:0;
                    display: none !important;
                }
            }

            html, body {
                height:100vh;
                width: 100vh;
                margin: 4px !important;
                padding-left: 5px !important;
                /*overflow: hidden;*/
            }
            @page{
                size: auto;
                margin-left: 0cm;
                margin-right: 0px;
                margin-top: 0cm;
                margin-bottom: 0px;
                padding: 0cm!important;
            }
        }
    </style>
</head>
<body>
                <table style="width: 10cm" class="table">
                    <tr class="text-center">
                        <td colspan="2">الملخص</td>
                    </tr>
                    <tr>
                        <td>الخزنة</td>
                        <td>الرئيسية</td>
                    </tr>
                    <tr>
                        <td>المستخدم</td>
                        <td>{{auth()->user()->name}}</td>
                    </tr>
                    <tr>
                        <td>من</td>
                        <td>{{request()->fromdate}}</td>
                    </tr>
                    <tr>
                        <td>إلى</td>
                        <td>{{request()->todate}}</td>
                    </tr>
                    <tr  class="text-center">
                        <td colspan="2">الصافى</td>
                    </tr>
                    <tr  class="text-center">
                        <td colspan="2">
                        {{currency(round($balance,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>إجمالى المبيعات</td>
                        <td>
                            {{currency(round($orders->grandTotal??0,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>
                                        عدد الفواتير
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{$orders->OrdersCount}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table">
                            <tr>
                                <td>الكاش</td>
                                <td>
                                    {{currency(round($orders->totalPaid??0,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                </td>
                            </tr>
                            <tr>
                                <td>الاجل</td>
                                <td>
                                    {{currency(round($orders->totalDue??0,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>مرتجعات المبيعات</td>
                        <td>{{$salesReturns->sum('return_value')}}</td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>
                                        عدد الفواتير
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{$salesReturns->count()}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table">
                            <tr>
                                <td>الكاش</td>
                                <td>{{$salesReturns->where('is_cash',1)->sum('return_value')}}</td>
                            </tr>
                            <tr>
                                <td>من الرصيد</td>
                                <td>{{$salesReturns->where('is_cash',0)->sum('return_value')}}</td>
                            </tr>
                            </table>
                        </td>
                    </tr>



                    <tr>
                        <td>إجمالى المشتريات</td>
                        <td>{{$purchase->grandTotal}}</td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>
                                        عدد الفواتير
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{$purchase->OrdersCount}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>الكاش</td>
                                    <td>
                                        {{currency(round($purchase->totalPaid??0,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>الاجل</td>
                                    <td>
                                        {{currency(round($purchase->totalDue??0,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>مرتجعات المشتريات</td>
                        <td>{{$purchaseReturns->sum('return_value')}}</td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>
                                        عدد الفواتير
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{$purchaseReturns->count()}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table">
                                <tr>
                                    <td>الكاش</td>
                                    <td>{{$purchaseReturns->where('is_cash',1)->sum('return_value')}}</td>
                                </tr>
                                <tr>
                                    <td>من الرصيد</td>
                                    <td>{{$purchaseReturns->where('is_cash',0)->sum('return_value')}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>المصروفات</td>
                        <td>
                            {{currency(round($expenses,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>المقبوضات</td>
                        <td>
                            {{currency(round($clientPayments,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>مدفوعات الموردين</td>
                        <td>
                            {{currency(round($supplierPayments,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('front.cashdebosit')</td>
                        <td>
                            {{currency(round($desposite,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>
                    <tr>
                        <td> المسحوبات النقدية </td>
                        <td>
                            {{currency(round($withdraw,2),currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                        </td>
                    </tr>

                </table>
</body>
</html>
