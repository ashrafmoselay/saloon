@php
if(isset($employee_id)){
    $expense->employee_id = $employee_id;
}
@endphp
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
                            <input name="created_at" type="text" value="{{($expense->created_at)?$expense->created_at->format('Y-m-d'):date('Y-m-d')}}" class="form-control pull-right" id="datepicker">
                        </div>
                        <!-- /.input group -->
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.title')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <input value="{{$expense->note}}" required name="note" type="text" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.tax')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    %
                                </div>
                                <input id="TaxValue" name="tax_value" value="{{old('tax_value')??($expense->tax_value ?? 0)}}" class="hide">
                                <input id="TaxVal" required value="{{old('tax')??($expense->tax ?? $settings['taxValue'])}}" name="tax" type="number" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>المبلغ قبل الضريبة</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <input id="ValueBefore" required value="{{$expense->value_before_tax??0}}" step="0.01" type="number" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>المبلغ بعد الضريبة</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <input id="ValueAfter" readonly value="{{$expense->value}}" name="value" type="number" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.Choose a safe')</label>
                            <select name="bank_id" class="form-control ">
                                @foreach(\App\Bank::where('id',auth()->user()->treasury_id)->get() as $bank)
                                    <option balance="{{$bank->balance}}"  value="{{$bank->id}}">{{$bank->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 {{$employee_id?'hide':''}}">
                        <div class="form-group">
                            <label>@lang('front.expense')</label>
                            <select style="width: 100%;" name="partner_id" class="form-control select2">
                                <option {{($expense->partner_id=='')?'selected':''}}  value="">@lang('front.general')</option>
                                @foreach(\App\Partner::get() as $partner)
                                    <option {{($expense->partner_id==$partner->id)?'selected':''}} value="{{$partner->id}}">{{$partner->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.Expense Type')</label>
                            <select required style="width: 100%;" name="expenses_type_id" class="form-control select2">
                                <option value="">@lang('front.select')</option>
                                @foreach(\App\ExpensesType::get() as $type)
                                    <option {{($expense->expenses_type_id==$type->id)?'selected':''}} value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-12 {{$employee_id?'':'hide'}}">
                        <div class="form-group">
                            <label>@lang('front.employee')</label>
                            <input class="form-control" type="hidden" name="employee_id" value="{{$employee_id or ''}}">
                            <select disabled="" style="width: 100%;" name="employee_id" class="form-control select2">
                                <option value="">@lang('front.select')</option>
                                @foreach(\App\Employee::get() as $emp)
                                    <option {{($expense->employee_id==$emp->id)?'selected':''}} value="{{$emp->id}}">{{$emp->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
    </div>
</section>
<script>
    $('.select2').select2();
    $('form').validator();

    $('#datepicker').datepicker({
        autoclose: true,
        rtl: true,
        format: 'yyyy-mm-dd',
        language: "{{\Session::get('locale')}}",
    });
    $(document).on("input","#ValueBefore,#ValueAfter,#TaxVal",function(e){
        var grandtotal = parseFloat($("#ValueBefore").val());
        var tax = parseFloat($("#TaxVal").val());
        var TaxValue = (grandtotal * (tax / 100));
        $("#TaxValue").val(TaxValue);
        grandtotal += TaxValue;
        grandtotal = parseFloat(grandtotal).toFixed(2);
        $("#ValueAfter").val(grandtotal)
    });

</script>
