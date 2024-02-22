@extends('layouts.app')
@php
	if($type=='client'){
		$title = trans('front.debt');
	}elseif($type=='supplier'){
		$title = trans('front.suppliersdebt');
	}
@endphp
@section('title',$title)
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			{{$title}}
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
						<table  id="dataList" class="table table-striped table-bordered" style="width: 100%">
							<thead>
							<tr>
								<th>#</th>
								<th>@lang('front.name')</th>
								<th>@lang('front.telephone')</th>
								<th>@lang('front.balance') </th>
								<th>@lang('front.Last Order')</th>
								<th>@lang('front.Last Payment')</th>
								<th>@lang('front.value')</th>
                                <th></th>
							</tr>
							</thead>
							<tbody>
							@foreach($persons as $person)
                                @php

                                       if(!$person->balnce_text){
                                            continue;
                                       }
                                       $flag = false;
                                       $transDate = $person->last_transaction?:$person->last_order;
                                       if($transDate){
                                           $now = \Carbon\Carbon::now();
                                           $last_transaction = new \Carbon\Carbon($transDate);
                                           if($now->diffInDays($transDate)>=30){
                                               $flag = true;
                                           }
                                       }
                                @endphp
								<tr class="{{$flag?'danger':''}}">
									<td>{{$loop->iteration}}</td>
									<td>{{$person->name}}</td>
									<td>{{$person->mobile}}</td>
                                    <td>{!! $person->balnce_text !!}</td>
									<td>{{$person->last_order}}</td>
									<td>{{$person->last_transaction}}</td>
									<td>{{$person->last_transaction_value}}</td>
									<td class="actions">
										<a href="{{route('persons.show',$person)}}" class="btn btn-warning btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.show')
										</a>
										<a data-toggle="modal" data-target="#myModal" href="{{route('persons.addPayment',$person)}}" class="btn btn-success btn-xs">
											<i class="fa fa-money fa-fw" aria-hidden="true"></i>
											@lang('front.Pay')
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
