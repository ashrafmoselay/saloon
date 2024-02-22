@extends('layouts.app')
@section('title',trans('front.movements'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.movements')
			<small>
				@lang('front.From store to store')
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('movements.store')}}" method="post">
		{{ csrf_field() }}
		@include('movements._form')
	</form>
@stop
