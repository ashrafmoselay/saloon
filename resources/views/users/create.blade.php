
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			إضافة
			<small>
				مستخدم
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form enctype="multipart/form-data" action="{{route('users.store')}}" method="post">
		{{ csrf_field() }}
		@include('users._form')
	</form>
