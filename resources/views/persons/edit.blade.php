	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$person->name}}
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('persons.update',$person)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
        <input type="hidden" name="page_display_start" value="{{$page_display_start??0}}">
		@php
			$type = $person->type;
		@endphp
		<input type="hidden" value="{{$person->type}}" name="type">
		@include('persons._form')
	</form>
