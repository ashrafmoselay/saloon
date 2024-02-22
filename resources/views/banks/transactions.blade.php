<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		@lang('front.addBankTrans')
		<small>
			{{$bank->name}}
		</small>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
	</h1>
</section>
<!-- Main content -->
<form action="{{route('banks.addTransaction',$bank)}}" method="post">
	{{ csrf_field() }}
	<section class="content">
		<div class="box box-primary">
			<div class="box-body">
				<div class="row">
					<div class="form-group col-md-12">
						<label for="">@lang('front.title')</label>
						<input required="" class="form-control" value="{{$bank->note}}" type="text" name="note">
					</div>
					<div class="form-group col-md-6">
						<label for="">@lang('front.date')</label>
						<input  name="op_date" value="{{date('Y-m-d')}}"  type="text" class="form-control datepicker22"  required="required" placeholder="التاريخ">

					</div>
					<div class="form-group col-md-6">
						<label for="">@lang('front.type')</label>
						<select id="type" name="type"  class="form-control">
							@if($bank->balance>0)
								<option value="1">@lang('front.withdraw')</option>
							@endif
							<option value="2">@lang('front.deposit')</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="">@lang('front.balance')</label>
						<input readonly="" name="total" value="{{$bank->balance}}"  min="0" type="number" step="0.01" class="form-control total" required="required">

					</div>
					<div class="form-group col-md-4">
						<label for="">@lang('front.value')</label>
						<input required="" name="value" min="0" type="number" step="0.01" class="form-control paid" required="required">

					</div>
					<div class="form-group col-md-4">
						<label for="">@lang('front.balance after')</label>
						<input name="due" readonly="" min="0" type="number" step="0.01" class="form-control due" required="required">

					</div>

				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">@lang('front.save')</button>
				</div>
			</div>
		</div>
	</section>
</form>

<script>
    $('.select2').select2();
    $('form').validator();
    $('.datepicker22').datepicker({format: 'yyyy-mm-dd',rtl: true});
    $(document).ready(function(){
        $(document).on("input",".paid",function(e){
            e.preventDefault();
            var due = parseFloat($(".total").val());
            if($("#type").val()==1) {
                due -= parseFloat($(".paid").val());
            }else{
                due += parseFloat($(".paid").val());
            }
            $(".due").val(due);
        });
        $(document).on("change","#type",function(e){
            $(".paid").trigger('input')
        });
    });
</script>
