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
        <form action="{{ route('partners.addProfitToPartner') }}" method="post">
            @csrf
            <div class="box-body row" style=" overflow: auto; width: 100%;">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.name')</th>
                                <th>@lang('front.percentage')</th>
                                <th>@lang('front.total profits')</th>
                                <th>@lang('front.general expenses')</th>
                                <th>@lang('front.grand profit')</th>
                                <th>مسحوبات</th>
                                <th>تسويات</th>
                                <th>@lang('front.partner profit')</th>
                                <th>@lang('front.grand profit')</th>
                                <th>الربح النهائي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $from= request()->fromdate;
                                $to= request()->todate;
                            @endphp
                            @foreach($partners as $partner)
                                @php
                                    $sptialExpenses = $partner->expenses;
                                    $partnerprofit = $partner->partnerprofit;
                                    $sptial = $sptialExpenses->sum('value');
                                    $taswia = $partnerprofit->sum('value');
                                    $partnerProfit = $grandProfit * ($partner->percent/100);
                                    $myprofit = $partnerProfit - $sptial  ;
                                    // if($myprofit){
                                    //     $myprofit -= $taswia;
                                    // }
                                    $finalProfit = $myprofit + $taswia ;

                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$partner->name}}</td>
                                    <td>{{$partner->percent}} %</td>
                                    @if($loop->iteration==1)
                                        <td class="bg-green rowTd" rowspan="{{count($partners)}}">{{currency(round($totalProfit,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                        <td class="bg-red rowTd" rowspan="{{count($partners)}}">{{currency(round($generalExpenses,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                        <td class="bg-primary rowTd" rowspan="{{count($partners)}}">{{currency(round($grandProfit,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                    @endif
                                    <td class="warning">{{$sptial}}</td>
                                    <td>{{ $taswia }}</td>
                                    <td class="info">{{currency(round($partnerProfit,2),currency()->config('default'),currency()->config('default'), true)}}</td>
                                    <td class="success">
                                        <input type="hidden" name="grandProfit" value="{{ $grandProfit }}"/>
                                        <input type="hidden" name="partner[{{ $loop->iteration }}][id]" value="{{ $partner->id }}"/>
                                        <input type="hidden" name="partner[{{ $loop->iteration }}][profit]" value="{{ round($myprofit,2) }}"/>
                                        {{currency(round($myprofit,2),currency()->config('default'),currency()->config('default'), true)}}
                                    </td>
                                    <td>{{ round($finalProfit,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-save"></i> تسوية الارياح </button>
                <a href="{{ route('taswia') }}" class="btn btn-success"><i class="fa fa-file"></i> تقرير التسويات</a>
            </div>
        </form>
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
            table,.badge,td,.bg-green,.bg-yellow,.bg-aqua,.bg-red,.bg-green {
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
