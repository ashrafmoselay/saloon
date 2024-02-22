@extends('layouts.app')
@section('content')
@section('title', 'تقرير المناديب')
<section class="content-header">
    <h1>
        تقرير المناديب
        <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
            <i class="fa fa-print" aria-hidden="true"></i>
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @include('layouts.partial.filter')
                    @include('layouts.partial.printHeader', ['showCompanyData' => true])
                </div>
                <div class="box-body">
                    <table id="dataList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>إجمالى مبيعات</th>
                                <th>إجمالى مرتجعات</th>
                                <th>إجمالى تحصيلات</th>
                                <th>إجمالى مديونيات</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $emp)
                                @php
                                    $sales = $emp->saleOrders->sum('total');
                                    $returns = $emp->saleReturnsOrder->sum('total');
                                    $collections = $emp->paymentsTransactions->sum('value');
                                    $due = $sales - (abs($returns) + abs($collections));
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $emp->name }}</td>
                                    <td>{{ number_format($sales, 2) }}</td>
                                    <td>{{ number_format($returns, 2) }}</td>
                                    <td>{{ number_format(abs($collections), 2) }}</td>
                                    <td>{{ number_format($due, 2) }}</td>
                                    <td>
                                        <a href="{{ route('employees.show', $emp) }}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            @lang('front.show')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@push('css')
<style>
    .table td {
        vertical-align: middle !important;
        text-align: center !important;
        font-size: 15px !important;
    }

    .progress-bar,
    .badge {
        width: 100%;
    }

    .badge {
        width: 100%;
        padding: 5px;
    }

    table,
    .badge,
    td {
        font-size: 14px !important;
        font-weight: bold !important;
    }

    @media print {

        table,
        .badge,
        td,
        .bg-green,
        .bg-yellow,
        .bg-aqua,
        .bg-red,
        .bg-green {
            font-size: 18px !important;
            color: #0c0c0c !important;
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
</script>
@endpush
