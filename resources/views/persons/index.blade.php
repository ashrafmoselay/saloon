@extends('layouts.app')

@php
	$title = '';
    $route = '';
    if($type=='client'){
        $title = trans('front.clients');
        $route = route('client.create');
    }elseif($type=='supplier'){
        $title = trans('front.suppliers');
        $route = route('supplier.create');
    }


@endphp
@section('title',$title)
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			{{$title}}
			<a data-toggle="modal" data-target="#myModal" class="btn btn-success pull-right" href="{{$route}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
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
						<table class="dataTableList table table-striped table-bordered" style="width: 100%">
							<thead>
							<tr>
								<th>#</th>
                                <th>@lang('front.name')</th>
                                <th>@lang('front.region')</th>
								<th>@lang('front.telephone')</th>
								<th>@lang('front.balance') </th>
                                <th>@lang('front.support')</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>

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
@push('dataTableJs')
    <script>
        var pageUrl = "{{$type=='client'?route('client.index'):route('supplier.index')}}";
        var columns= [
            {data: "id", name: "id"},
            {data: "name", name: "name"},
            {data: "regionname", name: "region.name"},
            {data: "mobileData", name: "mobile"},
            {data: "balnce_text", name: "balnce_text", orderable: false, searchable: false},
            {data: "remember_review_balance", name: "remember_review_balance"},
            {data:'actions',name:'actions', orderable: false, searchable: false}

        ];
    </script>
@endpush
