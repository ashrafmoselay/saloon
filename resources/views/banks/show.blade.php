@extends('layouts.app')
@section('title','تفاصيل '.$bank->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            تفاصيل - {{$bank->name}}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts.partial.filter')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                {{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
                <!-- /.box-header -->
                    <div class="box-body">
                        <table id="dataList" class="table table-bordered table-striped dataTableTT">
                            <thead>
                            <tr>
                                <th>#<span class="hide boxTiT"> الرصيد النهائى للخزنة : {{currency($bank->balance,$bank->currency,$bank->currency, $format = true)}} </span></th>
                                <th>التاريخ</th>
                                <td>المستخدم</td>
                                <th>البيان</th>
                                <th>نوع العملية</th>
                                <th>الرصيد قبل</th>
                                <th>المبلغ</th>
                                <th>الرصيد بعد</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $trans)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$trans->op_date}}</td>
                                    <td>{{optional($trans->creator)->name}}</td>
                                    <td class="text-center">{{$trans->note}}</td>
                                    <td class="text-center">{{$trans->type==1?'سحب':'إيداع'}}</td>
                                    <td class="text-center">{{$trans->total}}</td>
                                    <td class="text-center">{{$trans->value}}</td>
                                    <td class="text-center">{{$trans->due}}</td>
                                    <td>
                                        <a title="طباعه" href="{{ route('banktransaction',$trans->id) }}" class="btn btn-info btn-xs">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection
