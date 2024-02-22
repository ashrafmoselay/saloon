@extends('layouts.app')
@section('title','اوامر التصنيع')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    @include('layouts.partial.filter')
                    @include('layouts.partial.printHeader',['showCompanyData'=>true])
                    <div class="box-body">
                        <table id="dataList" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التاريخ</th>
                                    <th>اسم الصنف</th>
                                    <th>الكمية</th>
                                    <th>الخامات</th>
                                    <th class="hide"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->date}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->itemqty}}</td>
                                        <td>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach($item->details as $raw)
                                                        <tr>
                                                            <td>{{$raw->pivot->raw_name}}</td>
                                                            <td>{{$raw->pivot->totalneedqty}} {{$raw->pivot->raw_unit_text}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                        <td class="hide"></td>
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
