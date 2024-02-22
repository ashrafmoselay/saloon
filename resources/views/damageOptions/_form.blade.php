<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.name')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-life-bouy"></i>
                                </div>
                                <input value="{{$damageOption->name}}" required name="name" type="text" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
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
    $('form').validator();
</script>
