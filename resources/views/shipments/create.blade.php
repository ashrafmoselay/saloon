@extends('layouts.app')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Add')
			<small>
				@lang('front.shipment')
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('shipments.store')}}" method="post">
		{{ csrf_field() }}
		@include('shipments._form')
	</form>
@stop
