@extends('layouts.app')
@section('content')
@section('title','بيان اﻷرباح')
<section class="content-header">
	<h1>
		@lang('front.report')
		<small>
			@lang('front.profits')
		</small>
		<a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
			<i class="fa fa-print" aria-hidden="true"></i>
		</a>
	</h1>
</section>
<section class="content">
	<div class="box box-primary">
		@include('layouts.partial.filter')
		@include('layouts.partial.printHeader',['showCompanyData'=>true])
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>@lang('front.name')</th>
							<th>@lang('front.percentage')</th>
							<th>@lang('front.general expenses')</th>
							<th>@lang('front.parteners expenses')</th>
                            @if($settings['subtract_expenses_profit']==1)
							<th>@lang('front.discounts')</th>
							<th class="danger">@lang('front.ordreturn')</th>
                            @endif
							<th class="warning">@lang('front.total profits')</th>
							<th class="success">@lang('front.grand profit')</th>
						</tr>
					</thead>
					<tbody>
						@php
							$from= request()->fromdate;
							$to= request()->todate;
						@endphp
						@foreach($partners as $partner)
							@php
								$sptialExpenses = $partner->expenses();
								if($from){
									$sptial = $sptialExpenses->whereRaw("DATE(created_at) >= '{$from}'")
									->sum('value');
								}
								if($to){
									$sptial = $sptialExpenses->whereRaw("DATE(created_at) <= '{$to}'")->sum('value');
								}
								if(empty($from) && empty($to)){
									$sptial = $sptialExpenses->sum('value');
								}
								//$discountSum += $totalRetrunDiscount;
                                $totalProfit = $orders?$orders-$discountSum:0;

                                $gExpenses = 0;
								if($settings['subtract_expenses_profit']==1){
                                    $gExpenses = $generalExpenses*($partner->percent/100);
								}else{
                                    $totalProfit-=$generalExpenses;
								}
                                $totalRetutn = $returns?$returns:0;
                                $totalRetutn -= $totalRetrunDiscount;
                                //dd($totalRetutn);
                                //$totalProfit -= $totalRetutn;
								$totalProfit *= ($partner->percent/100);
                                $partnerReternPercent = $totalRetutn * ($partner->percent/100);
								$final = $totalProfit - $sptial - $gExpenses - $partnerReternPercent;
							@endphp
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$partner->name}}</td>
								<td>{{$partner->percent}} %</td>
                                @if($settings['subtract_expenses_profit']==1)
                                    <td>{{$gExpenses}}</td>
                                @else
                                    @if($loop->iteration==1)
                                        <td style="text-align: center;vertical-align: middle;background: #FFEB3B;color: #f50909;" rowspan="{{count($partners)}}">{{$generalExpenses}}</td>
                                    @endif
                                @endif
								<td>{{$sptial}}</td>
                                @if($settings['subtract_expenses_profit']==1)
								<td>{{$discountSum * ($partner->percent/100)}}</td>
								<td class="danger">{{currency($partnerReternPercent,currency()->config('default'),currency()->config('default'), true)}}</td>
                                @endif
								<td class="warning">{{currency($totalProfit,currency()->config('default'),currency()->config('default'), true)}}</td>
								<td class="success">{{currency($final,currency()->config('default'),currency()->config('default'), true)}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
            <div class="col-md-12">
                @if($settings['subtract_expenses_profit']==2)
                    <div class="bg-yellow" style="padding: 5px;">
                         المصروفات العامة لا يتم حسابها على حسب نسبة الشركاء بينما يتم طرحها من إجمالى الربح وتوزيع الربح على حسب نسبة الشركاء
                    </div>
                @endif
                <div class="bg-green" style="padding: 5px;margin-top: 10px;font-weight: bold">
                     إجمالى قيمة الربح : {{currency(round($ordersProfit,2),currency()->config('default'),currency()->config('default'), true)}}
                </div>

            </div>
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
            table,.badge,td,.bg-green,.bg-yellow,.bg-aqua,.bg-yellow {
                font-size: 18px !important;
                color: #0c0c0c!important;
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
            language: "{{\Session::get('locale')}}",
        });
      /*  $(document).on('change','.todate,.fromdate',function(e){
            e.preventDefault();
            alert();
            let todate = $('.todate').val();
            let fromdate = $('.fromdate').val();
		});*/
	</script>
@endpush
