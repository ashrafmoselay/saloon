@extends('layouts.app')
@section('title', trans('front.summary') . ' ' . $person->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.summary')
            <small>
                {{ $person->name }}
            </small>
            <a onclick="window.print();" href="javascript:void(0)" class="btn btn-info  print pull-right"><i class="fa fa-print"
                    aria-hidden="true"></i> طباعة</a>
            <button id="pdf-button" class="btn btn-success print-window pull-right"><i class="fa fa-file-pdf-o"
                    aria-hidden="true"></i> تحميل PDF</button>
        </h1>
        @include('layouts.partial.filter')
    </section>
    <!-- Main content -->
    <section class="content">
        @include('layouts.partial.printHeader', ['showCompanyData' => true])
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title"> كشف حساب {{ $person->name }}</h3>
                            </div>
                            <div class="col-md-4">
                                <p><strong>الرصيد الحالي: </strong> {!! $person->balnce_text !!}</p>
                                <p><strong>عدد الفواتير: </strong> {{ count($orders) }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>الفترة من:</strong> {{ request('fromdate') }}</p>
                                <p><strong>الفترة إلي:</strong> {{ request('todate') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>البيان</th>
                                            <th>فاتورة</th>
                                            <th>التاريخ</th>
                                            <th>دائن</th>
                                            <th>مدين</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $perTrans)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>{{ $perTrans->note }}</td>
                                                <td>
                                                    @if ($perTrans->record_id)
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>الصنف</th>
                                                                    <th>الكمية</th>
                                                                    <th>السعر</th>
                                                                    <th>الاجمالي</th>
                                                                    <th>الملاحظات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $order = $perTrans->order;
                                                                @endphp
                                                                @if ($perTrans->order)
                                                                    @foreach ($order->details as $item)
                                                                        @php
                                                                            $tqty = $item->pivot->qty;
                                                                            $tval = $tqty * $item->pivot->price;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $item->full_name }}</td>
                                                                            <td>{{ $tqty . ' ' . $item->pivot->unit_name }}
                                                                            </td>
                                                                            <td>{{ $item->pivot->price }}</td>
                                                                            <td>{{ number_format($tval, 2) }}</td>
                                                                            <td>{{ $order->note }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $perTrans->created_at ? $perTrans->date_ar : '' }}</td>
                                                <td>{{ $perTrans->value < 0 ? number_format(abs($perTrans->value), 2) : '------' }}
                                                </td>
                                                <td>{{ $perTrans->value > 0 ? number_format($perTrans->value, 2) : '------' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@push('css')
    <style>
        .table tr>td,
        .table tr>th {
            text-align: center;
            white-space: normal;
            word-wrap: break-word;
        }

        tr td,
        tr th {
            vertical-align: middle !important;
        }

        @media print {

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
                float: left;
            }

            .col-md-12 {
                width: 100%;
            }

            .col-md-11 {
                width: 91.66666667%;
            }

            .col-md-10 {
                width: 83.33333333%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-8 {
                width: 66.66666667%;
            }

            .col-md-7 {
                width: 58.33333333%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-5 {
                width: 41.66666667%;
            }

            .col-md-4 {
                width: 33.33333333%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-2 {
                width: 16.66666667%;
            }

            .col-md-1 {
                width: 8.33333333%;
            }
        }
    </style>
@endpush
