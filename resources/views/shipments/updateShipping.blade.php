
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        تعديل قيمة الشحن للأوردار رقم
        <small>
            {{$record->id}}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>
<!-- Main content -->
<form action="{{route('shipments.updateShipping',$record)}}" method="post">
    {{ csrf_field() }}
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>قيمة الشحن</label>
                            <input value="" required name="new_shipping_cost" type="text" class="form-control">
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

</form>
