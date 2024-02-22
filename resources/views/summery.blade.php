@extends('layouts.app')
@section('content')
@section('title','تقرير ملخص')
<section class="content-header">
	<h1>
        تقرير ملخص
        <small></small>
        <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
            <i class="fa fa-print" aria-hidden="true"></i>
        </a>
	</h1>
</section>
<section class="content">
	<div class="box box-primary">
		@include('layouts.partial.printHeader',['showCompanyData'=>true])
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>@lang('front.Summary Report')</strong>
                                </p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>@lang('front.title')</th>
                                        <th>@lang('front.total')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>@lang('front.Total Purchases')</td>
                                        <td>
                                            <div class="bg-yellow" style="padding: 5px;" >
                                                {{currency($totalPurchases,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('front.totalorders')</td>
                                        <td>
                                            @foreach($totalOrders as $item)
                                                <div class="bg-green" style="{{count($totalOrders)>1?'width: 48%;display: inline-block;':''}}padding: 5px;" >{{currency($item['total']-$discountSum,$item['currency'], $item['currency'], $format = true)}}</div>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('front.Suppliersdebts')</td>
                                        <td>
                                            {{currency($supplierdue,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('front.clients debts')</td>
                                        <td>
                                            {{currency($clientdue,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('front.Inventory')</td>
                                        <td>
                                            {{currency(round($gard->totalCost,2), currency()->config('default'), currency()->getUserCurrency(),true)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('front.Cash')</td>
                                        <td>
                                            <div style="padding: 5px;" class="bg-aqua">
                                            {{currency(round($treasury,2), currency()->config('default'), currency()->getUserCurrency(),true)}}
                                            </div>
                                        </td>
                                    </tr>
                                    {{--<tr>
                                        <td>الفيزا</td>
                                        <td>
                                            @foreach($treasury as $c=>$p)
                                                <div style="{{count($treasury)>1?'width: 48%;':''}}padding: 5px;" class=" bg-aqua">{{currency($p,$c, $c, $format = true)}}</div>
                                            @endforeach
                                        </td>
                                    </tr>--}}
                                    <tr>
                                        <td>@lang('front.Total budget')</td>
                                        <td>
                                            <div style="padding: 5px;"  class=" bg-red">
                                                {{currency($treasury + $clientdue  + $gard->totalCost - $supplierdue, currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>@lang('front.bestseller')</strong>
                                </p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('front.productsname')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bestSeller as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->product->name}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
	</div>
</section>
@stop
@push('css')
	<style>
	.progress-bar,.badge{
		width: 100%;
	}
	.badge {
		width: 100%;
		padding: 5px;
	}
	table,.badge,td {
		font-size: 14px !important;
		font-weight: bold !important;
	}
	@media print {
		table,.badge,td,.bg-green,.bg-yellow,.bg-aqua,.bg-red {
			font-size: 18px !important;
			color: #0c0c0c!important;
		}

	}
	</style>
@endpush
