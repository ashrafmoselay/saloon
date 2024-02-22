@extends('layouts.app')
@section('title','تفاصيل التحويل')
@section('content')
<section class="content-header hideprint">
    <h1>
        تفاصيل التحويل
        <small>
            {{$damage->id}}
        </small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    @include('layouts.partial.printHeader',['showCompanyData'=>true])
    <div class="row">
        <div class="col-md-12 hideprint">
            <h1>
                <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
                    <i class="fa fa-print" aria-hidden="true"></i> طباعة
                </a>
            </h1>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('front.product')</th>
                    <th>@lang('front.storefrom')</th>
                    <th>@lang('front.storeto')</th>
                    <th>@lang('front.quantity')</th>
                    <th>الوحدة</th>
                    <td>@lang('front.date')</td>
                    <th class="no-sort hide"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($damages as $damages)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$damages->product->name}}</td>
                        <td>{{optional($damages->from)->name}}</td>
                        <td>{{optional($damages->to)->name}}</td>
                        <td>{{$damages->qty}}</td>
                        <td>{{optional($damages->unit)->name}}</td>
                        <td>{{$damages->created_at}}</td>
                        <td class="actions hide">

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
