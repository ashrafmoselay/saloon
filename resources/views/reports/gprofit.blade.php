@extends('layouts.app')
@section('content')
@section('title','بيان ارباح فعلى')
<section class="content-header">
	<h1>
		تقرير الارباح الفعلى
		<small>
			  على ما تم تحصيله من العملاء
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
							<th>الإسم</th>
							<th>@lang('front.percentage')</th>
                            <th>@lang('front.total profits')</th>
							<th>@lang('front.general expenses')</th>
                            <th>@lang('front.grand profit')</th>
							<th>@lang('front.parteners expenses')</th>
                            <th>@lang('front.partner profit')</th>
                            <th>صافى ربح الشريك</th>
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
                                $percent = optional($partner->firststore)->percent??0;
                                $gExpenses = 0;
                                $totalProfit = $ordersProfit;
								if($settings['subtract_expenses_profit']==1){
                                    $gExpenses = $generalExpenses*($percent/100);
								}else{
                                    $totalProfit -= $generalExpenses;
								}
								$grandP = $ordersProfit-$generalExpenses;
								$partnerProfit = $grandP * ($percent/100);
								$final = $partnerProfit - $sptial;
							@endphp
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$partner->name}}</td>
								<td>{{$percent}} %</td>
                                @if($loop->iteration==1)
                                    <td class="bg-green rowTd" rowspan="{{count($partners)}}">{{currency(round($ordersProfit,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                    <td class="bg-red rowTd" rowspan="{{count($partners)}}">{{currency(round($generalExpenses,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                    <td class="bg-primary rowTd" rowspan="{{count($partners)}}">{{currency(round($grandP,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                @endif
								<td>{{$sptial}}</td>
								<td class="warning">{{currency($partnerProfit,currency()->config('default'),currency()->config('default'), true)}}</td>
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
        .rowTd{
            vertical-align: middle !important;
            text-align: center !important;
            font-size: 15px !important;
        }
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
            table,.badge,td,.bg-green,.bg-yellow,.bg-aqua,.bg-yellow,.bg-red {
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
