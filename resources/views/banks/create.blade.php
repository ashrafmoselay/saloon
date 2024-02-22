
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Add')
			<small>
				@if($type==1)
					@lang('front.bank')
				@else
					@lang('front.treasury')
				@endif
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('banks.store')}}" method="post">
		{{ csrf_field() }}
		@include('banks._form')
	</form>
