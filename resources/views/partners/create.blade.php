
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			إضافة
			<small>
				شريك
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('partners.store')}}" method="post">
		{{ csrf_field() }}
		@include('partners._form')
	</form>
