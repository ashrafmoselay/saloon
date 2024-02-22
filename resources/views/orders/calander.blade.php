
<div class="cal-item hide">
    <div class="row itemCalnader">
        <div class="col-md-6">
            <div class="form-group">
                <label>التاريخ</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input autocomplete="off" required name="duepayment[date][]" type="text" value="" class="form-control pull-right datepicker">
                </div>
                <!-- /.input group -->
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>المبلغ</label>
                <input required name="duepayment[value][]" type="number" value="" class="form-control QestValue pull-right">
            </div>
        </div>
        <div class="col-md-1">
            <a class="btn btn-sm bg-red removeCalander paymentdueClander" href="#"><i class="fa fa-minus-square"></i></a>
        </div>
    </div>
</div>
