	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			تعديل
			<small>
				{{$service->name}}
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('services.update',$service)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('PUT')  }}
		@include('services._form')
	</form>
