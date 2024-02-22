<section class="content">
    <div class="box box-primary">
        <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.name')</label>
                            <input value="{{$employee->name}}" required name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.telephone')</label>
                            <input value="{{$employee->mobile}}" name="mobile" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.type')</label>
                            <select name="type" class="form-control empType">
                                <option {{$employee->type=='normal'?'selected':''}} value="normal">@lang('front.fulltime')</option>
                                <option {{$employee->type=='sales'?'selected':''}} value="sales">@lang('front.sale')</option>
                                <option {{$employee->type=='markter'?'selected':''}} value="markter">@lang('front.marketer')</option>
                                <option {{$employee->type=='sales_manager'?'selected':''}}  value="sales_manager">مدير مبيعات</option>
                            </select>
                        </div>
                    </div>

                    <div id="salesManagerDiv" class="col-md-12 hide">
                        <div class="form-group">
                            <label>مدير المبيعات</label>
                            <select name="manager_id" class="form-control managerSelect">
                                <option value="">--- إختر مدير المبيعات ---</option>
                                @foreach(\App\Employee::where('type','sales_manager')->get() as $man)
                                <option {{$employee->manager_id==$man->id?'selected':''}} value="{{$man->id}}">{{$man->name}}</option>
                                @endforeach
                             </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>التارجت</label>
                            <input value="{{$employee->target}}" name="target" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('front.Salary')</label>
                            <input value="{{$employee->salary}}" name="salary" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('front.percentage')</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-pie-chart"></i>
                            </div>
                            <input value="{{$employee->percent?:0}}" name="percent" step="0.01" type="number" class="form-control pull-right">
                            <div class="input-group-addon">
                                %
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('front.working days')</label>
                            <input value="{{$employee->working_days}}" name="working_days" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('front.Daily salary')</label>
                            <input value="{{$employee->day_salary}}" name="day_salary" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.notes')</label>
                            <textarea name="note" class="form-control">{{$employee->note}}</textarea>
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
    $(document).on("change",'.empType',function(){
        if($(this).val()=='sales'){
            $("#salesManagerDiv").removeClass('hide');
        }else{
            $(".managerSelect").val('');
            $("#salesManagerDiv").addClass('hide');
        }
    });
    $(".empType").trigger("change");
    $('.select2').select2();
    $('form').validator();
</script>
