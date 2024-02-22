@extends('layouts.app')
@section('title','تفاصيل التحويل')
@section('content')
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$movement->id}}
			</small>

		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('movements.update',$movement)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('movements._form')
	</form>
@stop
