@extends('layouts.app')
@section('title',trans('front.damages'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
            @lang('front.Add Damage')
			<small>
				@lang('front.new')
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('damages.store')}}" method="post">
		{{ csrf_field() }}
		@include('damages._form')
	</form>
@stop
