@extends('layouts.app')

@php
	if($type=='sales'){
        $title = trans('front.ordersreturns');
        $route = route('orderReturn.create');
    }else{
        $title = trans('front.purchasereturns');
        $route = route('purchaseReturn.create');
    }

@endphp
@section('title',$title)
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			{{$title}}
			<a class="btn btn-success pull-right" href="{{$route}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
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
						<table id="dataList" class="table table-fixed table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
                                    <th>المستخدم</th>
									<th>@lang('front.date')</th>
									@if($type=='sales')
										<th>@lang('front.client')</th>
									@else
										<th>@lang('front.supplier')</th>
									@endif
                                    <th>@lang('front.sale')</th>
									<th>@lang('front.total')</th>
									<th>@lang('front.salediscount')</th>
									<th>@lang('front.payment')</th>
									<th class="no-sort"></th>
								</tr>
							</thead>
							<tbody>
							@foreach($returns as $return)
								<tr>
									<td>{{$loop->iteration}}</td>
                                    <td>{{optional($return->creator)->name}}</td>
									<td>{{$return->return_date}}</td>
                                    <td>{{optional($return->client)->name}}</td>
                                    <td>{{optional($return->saleMan)->name}}</td>
									<td>
										{{currency($return->return_value,$return->currency, $return->currency, $format = true)}}
									</td>
									<td>
										{{currency($return->sales_value,$return->currency, $return->currency, $format = true)}}
									</td>
									<td>
										{{$return->is_cash?trans('front.cash'):trans('front.from previous balance')}}
									</td>
									<td class="actions">
										<a href="{{route('returns.edit',$return)}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.edit')
										</a>
										<a data-toggle="modal" data-target="#addPersonModal"  href="{{route('returns.show',$return)}}" class="btn btn-warning btn-xs">
											<i class="fa fa-eye fa-fw" aria-hidden="true"></i>
											 @lang('front.show')
										</a>
										<a class="btn btn-xs btn-danger remove-record" data-toggle="modal" data-url="{{route('returns.destroy',$return)  }}" data-id="{{$return->id}}" data-target="#custom-width-modal">
											<i class="fa fa-trash"></i>
											@lang('front.delete')
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



@endsection
@push('css')
	<style>
		div.dataTables_paginate {
			text-align: left;
		}
		#myModal .modal-dialog {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
		}

		#myModal .modal-content {
			height: auto;
			min-height: 100%;
			breturn: 0 none;
			breturn-radius: 0;
		}
		.typeahead {
				z-index: 1051;
				direction: rtl;
		}

		.twitter-typeahead {
			width: 100%;
		}
		.tt-query {
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		}

		.tt-hint {
			color: #999
		}

		.tt-menu {    /* used to be tt-dropdown-menu in older versions */
			width: 380px;
			margin-top: 2px;
			padding: 4px 0;
			background-color: #fff;
			breturn: 1px solid #ccc;
			breturn: 1px solid rgba(0, 0, 0, 0.2);
			-webkit-breturn-radius: 4px;
			-moz-breturn-radius: 4px;
			breturn-radius: 4px;
			-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			box-shadow: 0 5px 10px rgba(0,0,0,.2);
		}

		.tt-suggestion {
			padding: 3px 20px;
			line-height: 24px;
			direction: rtl;
		}

		.tt-suggestion.tt-cursor,.tt-suggestion:hover {
			color: #fff;
			background-color: #0097cf;

		}

		.tt-suggestion p {
			margin: 0;
		}


	</style>
@endpush
