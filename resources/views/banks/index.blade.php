@extends('layouts.app')
@php

if($type==1)
	$title = trans('front.banks');
else
	$title = trans('front.treasury');
@endphp
@section('title',$title)
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
{{$title}}
<a data-toggle="modal" data-target="#myModal" class="btn btn-success pull-right" href="{{route('banks.create',['type'=>$type])}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>

		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				{{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
				<!-- /.box-header -->
					<div class="box-body">
						@if($type==1)
							<table id="dataList" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>#</th>
									<th>@lang('front.bankname')</th>
									<th>@lang('front.accountNumber')</th>
									{{-- <th>@lang('front.BalanceConverted')</th> --}}
									<th>@lang('front.balance')</th>
									{{-- <th>@lang('front.currency')</th> --}}
									<th class="no-sort"></th>
								</tr>
								</thead>
								<tbody>
								@foreach($banks as $bank)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$bank->name}}</td>
										<td>{{$bank->number}}</td>
										{{-- <td>{{currency($bank->balance,$bank->currency,currency()->getUserCurrency(), $format = true)}}</td> --}}
										<td>{{currency($bank->balance,$bank->currency,$bank->currency, $format = true)}}</td>
										{{-- <td>{{$bank->currency}}</td> --}}
										<td class="actions">
											<a data-toggle="modal" data-target="#myModal" href="{{route('banks.edit',$bank)}}" class="btn btn-primary btn-xs">
												<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
												@lang('front.edit')
											</a>
											<a class="btn btn-xs btn-danger remove-record" data-url="{{ route('banks.destroy',$bank)  }}" data-id="{{$bank->id}}">
												<i class="fa fa-trash"></i>
												@lang('front.delete')
											</a>
											<a href="{{route('banks.show',$bank)}}" class="btn btn-warning btn-xs">
												<i class="fa fa-eye" aria-hidden="true"></i>
												@lang('front.show')
											</a>

											<a data-toggle="modal" data-target="#myModal" href="{{route('banks.addTransaction',$bank)}}" class="btn btn-info btn-xs">
												<i class="fa fa-money" aria-hidden="true"></i>
												@lang('front.depositandwithdrawal')
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@else
							<table id="dataList" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>#</th>
									<th>@lang('front.treasury')</th>
									<th>@lang('front.currentbalance')</th>
									<th>@lang('front.currency')</th>
									<th class="no-sort"></th>
								</tr>
								</thead>
								<tbody>
								@foreach($banks as $bank)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$bank->name}}</td>
										<td>{{currency($bank->balance,$bank->currency,$bank->currency, $format = true)}}</td>
										<td>{{$bank->currency}}</td>
										<td class="actions">
											<a data-toggle="modal" data-target="#myModal" href="{{route('banks.edit',$bank)}}" class="btn btn-primary btn-xs">
												<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
												@lang('front.edit')
											</a>
                                            @if(!$loop->first)
											<a class="btn btn-xs btn-danger remove-record" data-url="{{ route('banks.destroy',$bank)  }}" data-id="{{$bank->id}}">
												<i class="fa fa-trash"></i>
												@lang('front.delete')
											</a>
                                            @endif
											<a href="{{route('banks.show',$bank)}}" class="btn btn-warning btn-xs">
												<i class="fa fa-eye" aria-hidden="true"></i>
												@lang('front.show')
											</a>

											<a data-toggle="modal" data-target="#myModal" href="{{route('banks.addTransaction',$bank)}}" class="btn btn-info btn-xs">
												<i class="fa fa-money" aria-hidden="true"></i>
												@lang('front.depositandwithdrawal')
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endif
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

	<div id="myModal" class="modal fade" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<p class="text-center"><div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i>                    @lang('front.Loading ....')                </div>                </p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
				</div>
			</div>
		</div>
	</div>
@endsection
