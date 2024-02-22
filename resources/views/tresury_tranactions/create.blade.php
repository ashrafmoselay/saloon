
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Add')
			<small>
				@lang('front.depositandwithdrawal')
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('tresuryTranactions.store')}}" method="post">
		{{ csrf_field() }}
		@include('tresury_tranactions._form')
	</form>
