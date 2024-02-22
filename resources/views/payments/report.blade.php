@extends('layouts.app')
@section('title',trans('front.payments'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.payments')
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		@include('layouts.partial.filter')
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				{{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
				<!-- /.box-header -->
					<div class="box-body">
						<table id="dataList" class="table table-bordered">
							<thead>
							<tr>
								<th>#</th>
                                <th>@lang('front.name')</th>
                                <th>@lang('front.sale')</th>
								<th>البيان</th>
								<th>@lang('front.paid')</th>
								<th>@lang('front.date')</th>
								<th>@lang('front.due')</th>
								<th class="hide"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($list as $item)
								<tr>

									<td>{{$loop->iteration}}</td>
                                    <td>
                                        <a href = "{{ route('persons.show',$item->id) }}" >
                                            {{$item->name}}
                                        </a>
                                    </td>
                                    <td>{{\App\Employee::find($item->sale_id)->name??''}} </td>
									<td>
                                        <span style="color: #dd4b39">{{ $item->note }}</span>
                                    </td>
                                    <td>
                                        {{abs($item->value)}}
                                    </td>
									<td>{{date('Y-m-d',strtotime($item->date))}}</td>
									<td>{{$item->total_due}}</td>
									<td class="hide"></td>
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
