@extends('layouts.app')
@section('title','مديونيات المندوبين')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            مديونيات المندوبين
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="dataList" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المندوب</th>
                                <th>إجمالى المديونيات</th>
                                <th class="no-sort"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($settings['subtract_payment_from_invoice']==1)
                                            {{$item->totalDept+($salesP[$item->id]??0)}}
                                        @else
                                            {{($item->totalDept - $item->totalReturn)+($salesP[$item->id]??0)}}
                                        @endif
                                    </td>
                                    <td class="actions">
                                        <a href="{{route('getRepresentativesDetail',$item->id)}}" class="btn btn-xs btn-warning">
                                            <i class="fa fa-eye"></i>
                                            تفاصيل
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
@endsection
