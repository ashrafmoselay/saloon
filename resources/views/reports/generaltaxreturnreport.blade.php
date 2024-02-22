@extends('layouts.app')
@section('title', 'الاقرار الضريبى للقيمة المضافة')
@section('content')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            تقرير عام الاقرار الضريبي
            <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
                <i class="fa fa-print" aria-hidden="true"></i>
            </a>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 style="width: 100%" class="box-title">
                            @include('layouts.partial.printHeader', ['showCompanyData' => true])
                        </h3>

                        <div class="row hideprint" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="col-md-5">
                                        <div class="form-group ">
                                            <input required id="fromdate" placeholder="@lang('front.datefrom')"
                                                autocomplete="off" style="direction: rtl;" name="fromdate"
                                                value="{{ request()->fromdate }}" type="text"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input id="todate" placeholder="@lang('front.dateto')" autocomplete="off"
                                                style="direction: rtl;" name="todate" value="{{ request()->todate }}"
                                                type="text" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit"
                                            class="btn btn-primary form-control">@lang('front.search')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            @foreach ($list as $row)
                                <div class="col-md-6">
                                    <div class="box {{ $row['bcolor'] }}">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{ $row['title'] }}</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            @foreach ($row['values'] as $v)
                                                {{ $v['name'] }} : {{ $v['value'] }} رس
                                                <hr />
                                            @endforeach
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            @endforeach
                            <div class="col-md-12">
                                <div style="color:{{ $finalTotalTax > 0 ? '#000000' : 'red' }}!important" class="taxDiv">
                                    إجمالي الضريبة المستحقة عن الفترة {{ number_format($finalTotalTax, 2) }} رس
                                </div>
                            </div>
                        </div>
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


    </div>


@endsection
@push('css')
    <style>
        .taxDiv {
            -webkit-print-color-adjust: exact;
            padding: 10px;
            font-size: 20px !important;
            font-weight: bold;
            text-align: center;
            border: 2px dashed #000000;
        }

        @media print {
            .box {
                border: 3px solid #000 !important;
            }

            .taxDiv {
                -webkit-print-color-adjust: exact;
                font-size: 20px !important;

            }

            .col-md-1,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-10,
            .col-md-11,
            .col-md-12 {
                float: right;
            }

            .col-md-1 {
                width: 8%;
            }

            .col-md-2 {
                width: 16%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-4 {
                width: 33%;
            }

            .col-md-5 {
                width: 42%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-7 {
                width: 58%;
            }

            .col-md-8 {
                width: 66%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-10 {
                width: 83%;
            }

            .col-md-11 {
                width: 92%;
            }

            .col-md-12 {
                width: 100%;
            }
        }
    </style>
@endpush
@push('js')
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{ \Session::get('locale') }}",
        });
        $(".select2").select2({
            allowClear: true
        });
    </script>
@endpush
