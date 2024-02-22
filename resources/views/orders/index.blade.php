@extends('layouts.app')

@php
    if ($type == 'sales') {
        $title = trans('front.orders');
        $route = route('order.create', ['notpopup' => 'yes']);
        $withdrawroute = route('order.create', ['notpopup' => 'yes', 'withdraw' => 1]);
    } else {
        $title = trans('front.purchases');
        $route = route('purchase.create', ['notpopup' => 'yes']);
    }
@endphp
@section('title', $title)
@section('content')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            {{ $title }}
            @if (isset($withdrawroute))
                <a style="margin-right: 5px;" class="btn btn-info pull-right" href="{{ $withdrawroute }}"><i
                        class="fa fa-plus"></i> @lang('front.Withdrawals')</a>
            @endif
            <a class="btn btn-success pull-right" href="{{ $route }}"><i class="fa fa-plus"></i> @lang('front.Add')</a>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    {{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div> --}}
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="dataTableList table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('front.invoicenumber')</th>
                                    <!--                                    <th>المستخدم</th>-->
                                    <th>@lang('front.date')</th>
                                    @if ($type == 'sales')
                                        <th>@lang('front.client')</th>
                                    @else
                                        <th>@lang('front.supplier')</th>
                                    @endif
                                    {{-- <th>المندوب</th> --}}
                                    <th>@lang('front.payment')</th>
                                    <th>@lang('front.total')</th>
                                    <th>@lang('front.discount')</th>
                                    <th>@lang('front.paid')</th>
                                    <th>@lang('front.due')</th>
                                    <th>@lang('front.status')</th>
                                    {{-- <th>الربح</th> --}}
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <div rel="flipInX" id="myModal" class="modal  modal-fullscreen" style="overflow-x:hidden;overflow-y: scroll;"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center">
                    <div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i> @lang('front.Loading ....') </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @include('orders.calander')

    <div id="myModalShipment" class="modal fade" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                    <div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i> @lang('front.Loading ....') </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        #myModal .modal-dialog {
            width: 100%;
            height: 100%;
        }

        .modal-content {
            height: 600px;
            overflow-y: auto;
        }

        #myModal .modal-content {
            height: auto;
            min-height: 100%;
            border: 0 none;
            border-radius: 0;
        }

        .typeahead {
            z-index: 1051;
            direction: rtl;
        }

        .twitter-typeahead {
            width: 100%;
            height: 28px;
        }

        .tt-query {
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        .tt-hint {
            color: #999
        }

        .tt-menu {
            /* used to be tt-dropdown-menu in older versions */
            width: 100%;
            margin-top: 2px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        }

        .tt-suggestion {
            padding: 3px 20px;
            line-height: 24px;
            direction: rtl;
        }

        .tt-suggestion.tt-cursor,
        .tt-suggestion:hover {
            color: #fff;
            background-color: #0097cf;

        }

        .tt-suggestion p {
            margin: 0;
        }
    </style>
@endpush
@push('dataTableJs')
    <script>
        var pageUrl = "{{ $urlRoute }}";
        var columns = [{
                data: "invoice_number",
                name: "invoice_number"
            },
            /*{data: "creator", name: "creator"},*/
            {
                data: "invoice_date",
                name: "invoice_date"
            },
            {
                data: "clientname",
                name: "client.name"
            },
            /*{data: "saleperson", name: "saleMan.name"},*/
            {
                data: "payment_type",
                name: "payment_type",
                orderable: false,
                searchable: false
            },
            {
                data: "total",
                name: "total"
            },
            {
                data: "dicount_value",
                name: "dicount_value"
            },
            {
                data: "paid",
                name: "paid"
            },
            {
                data: "due",
                name: "due"
            },
            {
                data: "status",
                name: "status"
            },
            //{data: "profit", name: "profit"},
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }

        ];
    </script>
@endpush
@push('js')
    <script>
        $(document).on("click", ".changeStatus", function(e) {
            e.preventDefault();
            var url = $(this).attr("href");
            swal({
                    title: "هل متأكد من تغيير حالة الفاتورة ؟ ",
                    text: "تغيير حالة الفاتورة الى مستلمة",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD4140",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    cancelButtonText: "إلغاء",
                    confirmButtonText: "نعم متأكد",
                },
                function() {
                    window.location = url;
                });
        });
    </script>
@endpush
