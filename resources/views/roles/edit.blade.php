@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$role->display_name}}
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('roles.update',$role)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('roles._form')
	</form>
@stop
