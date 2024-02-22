<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.name')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input value="{{$partner->name}}" required name="name" type="text" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>المبلغ المشترك به</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <input value="{{$partner->value}}" name="value" type="number" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>
                @foreach($stores as $store)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('front.store')</label>
                                <input type="hidden" value="{{$store->id}}" name="store[{{$loop->iteration}}][store_id]">
                                <input readonly value="{{$store->name}}" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>النسبة</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-pie-chart"></i>
                                    </div>
                                    <input value="{{$store->pivot->percent??0}}" required name="store[{{$loop->iteration}}][percent]" type="number" step="0.01" class="form-control pull-right">
                                    <div class="input-group-addon">
                                        %
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
</section>
<script>
    $('form').validator();
</script>
