@extends('layouts.app')
@section('title','مديونيات المندوب  '.$emp)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            مديونيات المندوب {{$emp}}
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
                                <th>اسم العميل</th>
                                <th>المنطقة</th>
                                <th>إجمالى المديونيات</th>
                                <th class="hide"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total = 0;
                                $grandTotal = 0;
                            @endphp
                            @foreach($list as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->region}}</td>
                                    @if($item->is_client_supplier==1)
                                        @php
                                            $person = \App\Person::find($item->id);
                                            $balance = $person->balnce_value;
                                            $total += $balance;
                                        @endphp
                                    <td>{{ $person->balnce_value }}</td>
                                    @else
                                    <td>
                                        @if($settings['subtract_payment_from_invoice']==1)
                                            @php
                                                $dvalue = $item->totalDept+($salesP[$item->id]??0);
                                                $grandTotal += $dvalue;
                                            @endphp
                                            {{$dvalue}}
                                        @else
                                            @php
                                                $dvalue = ($item->totalDept - $item->totalReturn)+($salesP[$item->id]??0);
                                                $grandTotal += $dvalue;
                                            @endphp
                                            {{$dvalue}}
                                        @endif
                                    </td>
                                    @endif
                                    <td class="hide"></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-danger">
                                    <td>الإجمالى</td>
                                    <td></td>
                                    <td></td>
                                    <td style="font-size: 18px;font-weight: bold;">{{$grandTotal}}</td>
                                    <td class="hide"></td>
                                </tr>
                            </tfoot>
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
