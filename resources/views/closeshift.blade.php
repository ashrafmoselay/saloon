
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @lang('front.CloseShift')
        <small>

        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>
<!-- Main content -->
<form action="{{route('closeShift')}}" method="post">
    {{ csrf_field() }}
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">@lang('front.title')</label>
                        <input required="" class="form-control" value="@lang('front.CloseShift')" type="text" name="note">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">@lang('front.date')</label>
                        <input readonly name="op_date" value="{{date('Y-m-d')}}"  type="text" class="form-control datepicker22"  required="required" placeholder="التاريخ">
                    </div>
                    <div class="form-group col-md-12">
                        <label>
                            @lang('front.In case of deportation, choose the safe')
                        </label>
                        <select name="bank_id" class="form-control select2">
                            <option value="">@lang('front.Withdrawal without transferring to another safe')</option>
                            @foreach($banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">@lang('front.currentbalance')</label>
                        <input readonly="" name="total" value="{{$cash}}"  min="0" type="number" step="0.01" class="form-control total" required="required">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">@lang('front.value')</label>
                        <input max="{{$cash}}" required="" name="value" min="0" type="number" step="0.01" class="form-control paid" required="required">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">@lang('front.balance after')</label>
                        <input name="due" readonly="" min="0" type="number" step="0.01" class="form-control due" required="required">
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('front.save')</button>
                </div>
            </div>
        </div>
    </section>
</form>
<script>
    $(document).ready(function(){
        $('.select2').select2();
        $(document).on("input",".paid",function(e){
            e.preventDefault();
            var due = parseFloat($(".total").val());
            var paid = parseFloat($(".paid").val());
            if(paid>due){
                swal({
                    title:'خطأ فى التقفيل', text:"المبلغ أكبر من المبلغ الموجود بالخزنة",type:"error",confirmButtonText: "تمام",
                });
                $(".paid").val(due);
                paid = due;
            }
            due -= paid;
            $(".due").val(due);
        });
        $(document).on("change","#type",function(e){
            $(".paid").trigger('input')
        });
    });
</script>
