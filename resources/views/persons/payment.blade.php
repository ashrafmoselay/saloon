
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.Pay')
			<small>
				{{$person->name}}
			</small>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		</h1>
	</section>
	<!-- Main content -->
	<form action="{{route('persons.addPayment',$person)}}" method="post">
		{{ csrf_field() }}
		<input name="calanderId" type="hidden" value="{{request('calanderId')}}">
		<section class="content">
			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>@lang('front.date')</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input name="created_at" type="text" value="{{date('Y-m-d')}}" class="form-control pull-right" id="datepicker22">
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>@lang('front.title')</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user"></i>
									</div>
									<input value="@lang('front.Debt Payment')" required name="note" type="text" class="form-control pull-right">
								</div>
								<!-- /.input group -->
							</div>
						</div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>إختر المندوب</label>
                                <select data-placeholder="@lang('front.select')" name="sale_id" class="form-control select2" style="width:100%;">

                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.Choose a safe')</label>
                                <select name="bank_id" class="form-control ">
                                    @foreach(\App\Bank::where('id',auth()->user()->treasury_id)->get() as $bank)
                                        <option balance="{{$bank->balance}}"  value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                    @foreach(\App\Bank::where('type',1)->get() as $bank)
                                        <option balance="{{$bank->balance}}"  value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

						<div class="col-md-6">
							<div class="form-group">
								<label>إضافة خصم عند التحصيل</label>
                                @if($person->type=='client')
								<div class="input-group">
									<input id="discount" value="0" required name="discount" type="number" step="0.01" class="form-control">
									<span class="input-group-addon btn">
										<input id="taswia" value="0"  name="taswia" type="hidden">
										<input id="taswia"  name="taswia" type="checkbox" class="flat-red ">
                                        @lang('front.taswiat')
                                    </span>
								</div>
                                @else
                                    <input id="discount" value="0" required name="discount" type="number" step="0.01" class="form-control">
                                @endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>@lang('front.value')</label>
								<div class="input-group">
									<div class="input-group-addon ">
										<i class="fa fa-money"></i>
										<span id="personBalance">{{round($person->balnce_value,1)}}</span>
									</div>
									<input id="personPaidMoney" value="" name="value" required type="number" step="0.01" class="form-control pull-right">
									<span class="input-group-addon btn ">
										<span id="PersonDue">{{round($person->balnce_value,1)}}</span>
									</span>
									@if($person->type=='client')
										<span class="input-group-addon btn hide">
											<input  name="is_client_paid" type="checkbox" class="flat-red ">
											@lang('front.payToClient')
										</span>
									@endif
								</div>
								<!-- /.input group -->
							</div>
						</div>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
                    <input id="savePrint" type="hidden" name="savePrint" value="" />
					<button type="submit" class="btn btn-primary">@lang('front.save')</button>
                    <button type="submit" class="btn btn-success saveandPrint"><i class="fa fa-print"></i> حفظ وطباعة </button>
                </div>
			</div>
		</section>

	</form>

	<script>
        $('#datepicker22').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",

        });

        $(document).on('click','.saveandPrint',function(e){
            e.preventDefault();
            $('#savePrint').val('print');
            $('form').submit();
        });
        $(".select2").select2({
            placeholder: "إختر المندوب",
            allowClear: true,
            minimumInputLength: 1,
            language: {
                inputTooShort: function () { return 'أكتب حرف او أكثر'; },
                noResults: function () { return "لا يوجد نتائج مطابقة للبحث"; },
                searching: function () { return "جارى البحث ..."; }
            },
            ajax: {
                url: '{{route('getEmployeeList')}}?client_id={{$person->id}}',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        $('form').validator();
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        $('body').on("input","#personPaidMoney",function(e){
            e.preventDefault();
            var due = parseFloat($("#personBalance").html()) - parseFloat($("#personPaidMoney").val());
            var discount = parseFloat($("#discount").val());
            due -= discount;
            //console.log(parseFloat($("#personPaidMoney").html()));
            var dueelm = $('#PersonDue').parent('span');
			if(due<0){
                dueelm.removeClass('bg-yellow');
                dueelm.addClass('bg-red')
            }
            if(due>0){
                dueelm.removeClass('bg-red');
                dueelm.addClass('bg-yellow')
            }
            $("#PersonDue").html(due.toFixed(1));
        });
	</script>
