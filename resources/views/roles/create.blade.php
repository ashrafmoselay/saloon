@extends('layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			إضافة
			<small>
				مستخدم
			</small>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('roles.store')}}" method="post">
		{{ csrf_field() }}
		@include('roles._form')
	</form>
@stop