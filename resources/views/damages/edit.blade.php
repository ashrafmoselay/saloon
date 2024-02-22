@extends('layouts.app')
@section('title','تفاصيل التحويل')
@section('content')
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$damage->id}}
			</small>

		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('damages.update',$damage)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('damages._form')
	</form>
@stop
