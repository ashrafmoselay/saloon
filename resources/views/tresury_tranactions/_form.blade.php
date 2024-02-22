<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.title')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <input value="{{$tresuryTranaction->note}}" required name="note" type="text" class="form-control pull-right">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.type')</label>
                            <select required name="type" class="form-control">
                                <option {{($tresuryTranaction->type=='deposite')?'selected':''}}  value="deposite">@lang('front.deposit')</option>
                                <option {{($tresuryTranaction->type=='withdraw')?'selected':''}} value="withdraw">@lang('front.withdraw')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.value')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <input required value="{{$tresuryTranaction->value}}" name="value" type="number" step="0.01" class="form-control pull-right">
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
