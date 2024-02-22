@extends('layouts.app')
@section('title','الصلاحيات')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.roles')
            @if(auth()->user()->can('create RolesController'))
			    <a class="btn btn-success pull-right" href="{{route('roles.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
            @endif
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
								<td>#</td>
								<th>@lang('front.name')</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($roles as $role)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$role->display_name}}</td>
									<td class="actions">
                                        @if(auth()->user()->can('edit RolesController'))
										<a href="{{route('roles.edit',$role)}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.edit')
										</a>
                                        @endif
                                        @if(auth()->user()->can('destroy RolesController'))
										<a class="btn btn-xs btn-danger remove-record"  data-url="{{ route('roles.destroy',$role)  }}" data-id="{{$role->id}}">
											<i class="fa fa-trash"></i>
											@lang('front.delete')
										</a>
                                        @endif

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
	<!-- Delete Model -->
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
