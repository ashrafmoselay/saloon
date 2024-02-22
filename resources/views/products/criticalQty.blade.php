@extends('layouts.app')
@section('title',trans('front.requiredproducts'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.requiredproducts')
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
						<table id="dataList" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>#</th>
								<th>@lang('front.product')</th>
								<th>@lang('front.quantity')</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($products as $product)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$product->name}}</td>
									<td>
										{!! $product->getTotalQuantity() !!}
									</td>
									<td class="actions">
										<a data-toggle="modal" data-target="#myModal" href="{{route('products.edit',$product)}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.edit')
										</a>
										<a class="btn btn-xs btn-danger remove-record" data-url="{{ route('products.destroy',$product)  }}" data-id="{{$product->id}}">
											<i class="fa fa-trash"></i>
											@lang('front.delete')
										</a>
										<a href="{{route('products.show',$product)}}" class="btn btn-xs btn-warning">
											<i class="fa fa-eye"></i>
											تفاصيل
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
		<div class="modal-dialog modal-lg">
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
