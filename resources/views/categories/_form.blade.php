<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('front.type')</label>
                        <select name="type" class="form-control select2" style="width: 100%;">
                            <option {{($category->type==1)?'selected':''}} value="1">@lang('front.parent')</option>
                            <option {{($category->type==2)?'selected':''}}  value="2">@lang('front.child')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('front.name')</label>
                        <input value="{{$category->name}}" required name="name" type="text" class="form-control pull-right">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>نسبة زيادة سعر البيع القطاعى عن الشراء</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="percentage" class="form-control  pull-right" value="{{$category->percentage or 0}}" type="text" placeholder="نسبة زيادة السعر القطاعى عن الجملة">
                            <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>نسبة زيادة سعر البيع نصف الجملة عن الشراء</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="half_percentage" class="form-control  pull-right" value="{{$category->half_percentage or 0}}" type="text">
                            <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>نسبة زيادة سعر البيع الجملة عن الشراء</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="percentage2" class="form-control  pull-right" value="{{$category->percentage2 or 0}}" type="text">
                            <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>نسبة زيادة سعر البيع جملة الجملة عن الشراء</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="percentage3" class="form-control  pull-right" value="{{$category->percentage3 or 0}}" type="text">
                            <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                        </div>
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

<script>
    $(function () {
        $(".select2").select2();
        $('form').validator();
    });
</script>
