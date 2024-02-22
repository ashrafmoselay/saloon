	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.edit')
			<small>
				{{$user->name}}
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form enctype="multipart/form-data" action="{{route('users.update',$user)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('users._form')
	</form>
