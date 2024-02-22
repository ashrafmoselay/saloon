
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			نقل الصنف الى شحنة أخرى
			<small>
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('shipments.transfer',$prodid)}}" method="post">
		{{ csrf_field() }}
		<section class="content">
			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>اكتب رقم الشحنة المحول اليها</label>
                                <input value="" required name="shipment_id" type="number" class="form-control">
							</div>
						</div>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">@lang('front.save')</button>
				</div>
			</div>
		</section>

	</form>
