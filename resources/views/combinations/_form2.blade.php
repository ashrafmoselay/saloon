<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>الالوان</label>
                            <select required style="width: 100%;" multiple name="color[]" class="form-control select2"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>المقاسات</label>
                            <select required style="width: 100%;" multiple name="size[]" class="form-control select2"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                <input class="flat-red" name="deleteprev"  type="checkbox">
                                هل تريد مسح جميع المواصفات السابقة!!
                                <span style="color: red"><i class="fa fa-warning"></i> سوف يتم مسح جميع المواصفات التى تمت اضافتها من قبل</span>
                            </label>
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
    $('.select2').select2({"tags":true});
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-blue'
    });
</script>
