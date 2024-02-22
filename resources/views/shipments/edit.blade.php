@extends('layouts.app')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$shipment->id}}
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('shipments.update',$shipment)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('shipments._form')
	</form>
    @stop
