@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$return->id}}
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('returns.update',$return)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('returns._form')
	</form>
@stop
