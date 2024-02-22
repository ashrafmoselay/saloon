@extends('layouts.app')

@section('title',trans('front.Add'))

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Add')
			<small>
				@php
					$title = '';
                    if($type=='client'){
                        $title = trans('front.client');
                    }elseif($type=='supplier'){
                        $title = trans('front.supplier');
                    }elseif($type=='sale'){
                        $title = 'مندوب مبيعات جديد';
                    }else{
                    	$title = 'مسوق';
                    }
				@endphp
				{{$title}}
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form id="personForm" action="{{route('persons.store')}}" method="post">
		{{ csrf_field() }}
		<input type="hidden" value="{{$type}}" name="type">
		@include('persons._form')
	</form>
@stop
