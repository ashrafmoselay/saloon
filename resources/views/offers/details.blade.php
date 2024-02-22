@extends('layouts.app')
@section('title',trans('front.orderdetails'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.orderdetails')
		</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">

				 <div class="box-header">
					 @include('layouts.partial.filter')
                 </div>
				<!-- /.box-header -->
					<div class="box-body">
						<table id="dataList" class="table table-bordered table-striped">
							<thead>
								<tr>
                                    <th>#</th>
                                    <th>@lang('front.invoicenumber')</th>
                                    <th>@lang('front.name')</th>
                                    <th>@lang('front.date')</th>
                                    <th>@lang('front.product')</th>
                                    <th>@lang('front.quantity')</th>
                                    <th>@lang('front.saleprice')</th>
                                    <th>@lang('front.sale')</th>
								</tr>
							</thead>
							<tbody>
                            @php
                                $index = 0;
                            @endphp
							@foreach($orders as $order)
                                @foreach($order->details as $item)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>{{$order->invoice_number}}</td>
                                        <td>{{optional($order->client)->name}}</td>
                                        <td>{{$order->invoice_date}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->pivot->qty}}</td>
                                        <td>{{$item->pivot->price}}</td>
                                        <td>{{optional($order->saleMan)->name}}</td>
                                    </tr>
                                @endforeach
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
