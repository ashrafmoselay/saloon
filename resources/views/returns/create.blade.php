@extends('layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Add')
			<small>
				@if($type=='sales')
					@lang('front.ordreturn')
				@else
					@lang('front.purreturn')
				@endif
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('returns.store')}}" method="post">
		{{ csrf_field() }}
		@include('returns._form')
	</form>
@stop
