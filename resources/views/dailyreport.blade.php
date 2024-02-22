@extends('layouts.app')
@section('content')
@section('title','بيان بكشــــف اليــــوميـــــة')
<section class="content-header">
	<h1>
		@lang('front.report')
		<small>
			@lang('front.dailyreport')
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
							<th class="text-center">@lang('front.title')</th>
							<th class="text-center">@lang('front.Outcome')</th>
							<th class="text-center">@lang('front.Income')</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td> @lang('front.later sales')</td>
						<td></td>
						<td>
							@foreach($dueOrder as $c=>$p)
							<div style="{{count($dueOrder)>1?'width: 48%;':''}}" class="badge bg-fegault">
								{{currency(round($p,2),$c, $c, $format = true)}}
							</div>
							@endforeach
						</td>
					</tr>
					@if(count($visapaid)>1 || $visapaid[currency()->config('default')])
						<tr>
							<td>@lang('front.visasales') </td>
							<td></td>
							<td>
								@foreach($visapaid as $c=>$p)
									<div style="{{count($visapaid)>1?'width: 48%;':''}}" class="badge bg-blue">
										{{currency(round($p,2),$c, $c, $format = true)}}
									</div>
								@endforeach
							</td>
						</tr>
					@endif
					<tr>
						<td> @lang('front.cash sales')</td>
						<td></td>
						<td>
							@foreach($paid as $c=>$p)
								<div style="{{count($paid)>1?'width: 48%;':''}}" class="badge bg-green">
									{{currency(round($p,2),$c, $c, $format = true)}}
								</div>
							@endforeach
						</td>
					</tr>
					<tr>
						<td>@lang('front.clients payments')</td>
						<td></td>
						<td><div class="badge bg-green">{{round($clienttotalPayment,2)}}</div></td>
					</tr>
					<tr>
						<td>@lang('front.cashdebosit')</td>
						<td></td>
						<td>
							@foreach($depositeTrans as $c=>$p)
								<div style="{{count($depositeTrans)>1?'width: 48%;':''}}" class="badge bg-green">
									{{currency(round($p,2),$c, $c, $format = true)}}
								</div>
							@endforeach
						</td>
					</tr>
					{{--<tr>
						<td>المجمــــــــوع</td>
						<td></td>
						<td><div class="badge bg-light-blue">{{round($orders+$clienttotalPayment+$deposite,2)}}</div></td>
					</tr>--}}
					<tr>
						<td>@lang('front.expenses')</td>
						<td><div class="badge bg-red">{{round($expenses,2)}}</div></td>
						<td></td>
					</tr>
					<tr>
						<td> @lang('front.cash purcahses') </td>
						<td><div class="badge bg-red">{{round($purchases,2)}}</div></td>
						<td></td>
					</tr>
					<tr>
						<td>@lang('front.cash withdraw')</td>
						<td>

							@foreach($withdrawTrans as $c=>$p)
								<div style="{{count($withdrawTrans)>1?'width: 48%;':''}}" class="badge bg-red">
									{{currency(round($p,2),$c, $c, $format = true)}}
								</div>
							@endforeach
						</td>
						<td></td>
					</tr>
					<tr>
						<td>@lang('front.suppliers payments')</td>
						<td><div class="badge bg-red">
								{{currency(round($suppliertotalPayment,2),currency()->config('default'), currency()->config('default'), $format = true)}}
							</div>
						</td>
						<td></td>
					</tr>
					{{--<tr>
						<td>المجمــــــــوع</td>
						<td></td>
						<td><div class="badge bg-light-blue">{{round($expenses+$purchases+$withdraw+$suppliertotalPayment,2)}}</div></td>
					</tr>--}}

					<tr>
						<td>@lang('front.pervious balance')</td>
						<td colspan="2">
							@foreach($prevBalance as $c=>$p)
								<div style="{{count($prevBalance)>1?'width: 48%;':''}}" class="badge bg-yellow">
									{{currency(round($p,2),$c, $c, $format = true)}}
								</div>
							@endforeach
						</td>
					</tr>
					<tr>
						<td>@lang('front.today balance')</td>
						<td colspan="2">
							@foreach($todayBalance as $c=>$p)
							<div style="{{count($todayBalance)>1?'width: 48%;':''}}" class="badge bg-yellow">
								{{currency(round($p,2),$c, $c, $format = true)}}
							</div>
							@endforeach
						</td>
					</tr>
					<tr>
						<td>@lang('front.final balance')</td>
						<td colspan="2">
							@foreach(currency()->getActiveCurrencies() as $currency)
								<div style="{{count($todayBalance)>1?'width: 48%;':''}}" class="badge bg-aqua">
									@php
									$value = ($todayBalance[$currency['code']]??0)+($prevBalance[$currency['code']]??0);
									@endphp
									{{currency(round($value,2),$currency['code'], $currency['code'], $format = true)}}
								</div>
							@endforeach
						</td>
					</tr>
					</tbody>
				</table>
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
	table,.badge {
		font-size: 14px !important;
		font-weight: bold !important;
	}
	@media print {
		table,.badge {
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
	</script>
@endpush
