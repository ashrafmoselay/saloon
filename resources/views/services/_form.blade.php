<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                        <input type="hidden" name="is_service" value="1">
                        <div class="form-group col-md-6">
                            <label>@lang('front.name')</label>
                            <input value="{{$service->name}}" required name="name" type="text" class="form-control pull-right">
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('front.saleprice')</label>
                            <input value="{{$service->last_cost}}" required name="last_cost" type="text" class="form-control pull-right">
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('front.parent')</label>
                            <select required name="main_category_id" class="form-control select2" style="width: 100%;">
                                @foreach($categories->where('type',1) as $cat)
                                    <option {{($service->main_category_id==$cat->id)?'selected':''}} value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('front.child')</label>
                            <select name="product[sub_category_id]" class="form-control select2" style="width: 100%;">
                                <option value="">@lang('front.select')</option>
                                @foreach($categories->where('type',2) as $cat)
                                    <option {{($cat->id==$service->sub_category_id)?'selected':''}} value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('front.code')</label>
                            <input value="{{($service->code)?$service->code:rand(1,9).str_random(10)}}" name="code" type="text" class="form-control ">
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('front.notes')</label>
                            <input value="{{$service->note}}" name="note" type="text" class="form-control ">
                        </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
</section>
<script>
    $(function () {
        $(".select2").select2();
        $('form').validator();
    });
</script>
