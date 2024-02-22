	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$store->name}}
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('stores.update',$store)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('stores._form')
	</form>
